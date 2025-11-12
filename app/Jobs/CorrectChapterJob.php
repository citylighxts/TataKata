<?php

namespace App\Jobs;

use App\Models\DocumentChapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CorrectChapterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chapter;
    public $timeout = 600; // 10 menit timeout per bab

    /**
     * Create a new job instance.
     */
    public function __construct(DocumentChapter $chapter)
    {
        $this->chapter = $chapter->withoutRelations();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $chapter = $this->chapter;
        Log::info("CorrectChapterJob started for Chapter ID: {$chapter->id}");

        try {
            // Tandai sebagai Processing
            $chapter->update([
                'status' => 'Processing',
                'details' => 'Mengirim teks ke AI...'
            ]);

            // Panggil fungsi koreksi Ollama
            $corrected_text = $this->correctTextWithOllama($chapter->original_text, $chapter->id);

            // Cek hasil
            if (str_starts_with($corrected_text, 'ERROR:')) {
                throw new \Exception($corrected_text);
            }
            
            // Perbaikan kecil: Cek jika balasannya masih rangkuman (sebagai fallback)
            if (str_starts_with($corrected_text, 'Analisis Laporan') || str_starts_with($corrected_text, 'Berdasarkan pendahuluan')) {
                 Log::warning("Model masih merangkum (Chapter {$chapter->id}). Mengembalikan teks asli.");
                 // Kita anggap gagal agar user bisa coba lagi
                 throw new \Exception('Model AI gagal mengoreksi dan malah merangkum. Coba ganti model (misal: llama3).');
            }

            // Sukses
            $chapter->update([
                'status' => 'Completed',
                'corrected_text' => $corrected_text,
                'details' => 'Koreksi selesai.'
            ]);
            
            Log::info("CorrectChapterJob finished for Chapter ID: {$chapter->id}");

        } catch (\Exception $e) {
            Log::error("CorrectChapterJob Failed for ID {$chapter->id}: " . $e->getMessage());
            $chapter->update([
                'status' => 'Failed', 
                'details' => 'Pemrosesan gagal: ' . substr($e->getMessage(), 0, 250)
            ]);
        }
    }

    /**
     * Mengoreksi teks menggunakan Ollama (LOKAL)
     */
    private function correctTextWithOllama($text, $chapterId)
    {
        $jobStart = microtime(true);
        try {
            // Cache check
            $cacheKey = 'doc_correction_ollama_' . sha1($text); 
            if (Cache::has($cacheKey)) {
                Log::info("Cache hit for chapter {$chapterId} (key={$cacheKey}).");
                return Cache::get($cacheKey);
            }
            
            $modelName = env('OLLAMA_MODEL', 'llama3:latest'); // Pastikan .env sudah diubah
            $url = env('OLLAMA_URL', 'http://127.0.0.1:11434/api/generate');
            $timeoutDuration = 540; 

            $textLen = mb_strlen($text, 'UTF-8');
            Log::info("Processing chapter {$chapterId} with OLLAMA: model={$modelName}, length={$textLen} chars", [
                'chapter_id' => $chapterId,
                'text_length' => $textLen,
            ]);

            // normalisasi ringan sebelum membuat prompt (letakkan sebelum prompt)
            $text = trim(mb_convert_encoding($text, 'UTF-8', 'UTF-8'));
            $text = preg_replace('/[^\S\n]+/u', ' ', $text);
            $text = preg_replace('/\n{3,}/', "\n\n", $text);

            // prompt: rekomendasi kalimat (pilih-pilih, tanpa "no correction" per baris)
            $promptString =
                "INSTRUKSI: Gunakan Bahasa Indonesia baku dan gaya formal (akademik). Tugas Anda bukan merangkum, melainkan memberikan REKOMENDASI PERBAIKAN KALIMAT untuk bagian yang dapat ditingkatkan.\n\n" .
                "ATURAN PENTING:\n" .
                "1) Tampilkan HANYA kalimat atau frasa yang PERLU diperbaiki. Jangan menampilkan baris yang sudah baik.\n" .
                "2) Jangan menambahkan teks seperti 'No correction needed', 'Tidak ada perubahan', atau komentar per baris.\n" .
                "3) Untuk setiap rekomendasi tampilkan dua baris dengan format EXACT:\n" .
                "- \"<Teks Asli>\"\n" .
                "  -> \"<Rekomendasi Perbaikan>\"\n" .
                "4) Sisipkan satu baris kosong antar item. Jika tidak ada satu pun kalimat yang perlu diperbaiki di seluruh teks, kembalikan persis satu baris: Dari teks tersebut tidak ada yang perlu dikoreksi.\n\n" .
                "CONTOH:\n" .
                "- \"analisa tehnik adalah penting. untuk industri.\"\n" .
                "  -> \"Analisis teknik adalah penting untuk industri.\"\n\n" .
                "--- TEKS ASLI ---\n" .
                $text . "\n\n" .
                "--- SELESAI ---";

            // Format Payload OLLAMA
            $payload = [
                'model' => $modelName,
                'prompt' => $promptString,
                'stream' => false,
            ];

            Log::info("MENGIRIM KE OLLAMA (Chapter: {$chapterId})", ['prompt' => $promptString]);

            $response = Http::withOptions(['timeout' => $timeoutDuration])->post($url, $payload);

            Log::info("MENERIMA DARI OLLAMA (Chapter: {$chapterId})", ['body' => $response->body()]);

            if (! $response->successful()) {
                $status = $response->status();
                $errorBody = $response->body();
                Log::error("Ollama HTTP Error (Chapter {$chapterId}): status={$status} body=" . substr($errorBody, 0, 500));
                
                if (str_contains($errorBody, 'context window')) {
                    return "ERROR: Teks bab terlalu besar untuk model ini.";
                }
                return "ERROR: Gagal menghubungi API Ollama (Status: {$status})";
            }

            $json = $response->json();

            if (empty($json['response'])) {
                Log::warning("Ollama response missing 'response' key.", ['response_json' => $json, 'chapter_id' => $chapterId]);
                return "ERROR: API Ollama tidak memberikan hasil koreksi.";
            }

            // Ambil hasil mentah dari Ollama
            $raw = trim($json['response']);

            // Bersihkan output agar tidak ada "No correction needed" atau duplikat
            $clean = $this->normalizeCorrections($raw);

            // Simpan hasil ke cache
            Cache::put($cacheKey, $clean, now()->addDays(7));

            $totalTook = round(microtime(true) - $jobStart, 3);
            Log::info("Chapter {$chapterId} correction finished (Ollama): total_time={$totalTook}s");

            return $clean;


        } catch (\Exception $e) {
            Log::error("Ollama Request Exception (Chapter {$chapterId}): " . $e->getMessage());
            return "ERROR: " . $e->getMessage();
        }
    }

    private function normalizeCorrections(string $raw): string
    {
        $normalized = str_replace(["\r\n", "\r"], "\n", $raw);
        $pairs = [];

        $pattern = '/-\s*"([^"]+)"\s*(?:->|\n\s*->)\s*(?:"([^"]+)"|No correction needed|Tidak ada koreksi)/mi';

        if (preg_match_all($pattern, $normalized, $m, PREG_SET_ORDER)) {
            foreach ($m as $match) {
                $orig = trim($match[1]);
                $fix = isset($match[2]) ? trim($match[2]) : null;

                if ($fix === null || preg_match('/no correction needed|tidak ada koreksi/i', $match[0])) {
                    continue;
                }
                if ($orig === $fix) continue;

                $pairs[] = sprintf("- \"%s\"\n  -> \"%s\"", $orig, $fix);
            }
        }

        if (empty($pairs)) {
            return "Dari teks tersebut tidak ada yang perlu dikoreksi.";
        }

        return "Koreksi Ejaan dan Tata Bahasa:\n\n" . implode("\n\n", $pairs);
    }
}