<?php
namespace App\Jobs;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http as HttpFacade;

class ProcessDocumentCorrection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $document;
    protected $documentId;
    public $timeout = 900; // 15 minutes total job timeout

    public function __construct(Document $document)
    {
        $this->document = $document->withoutRelations();
        $this->documentId = $document->id;
    }

    public function handle()
    {
        $document = Document::find($this->documentId);
        if (! $document) {
            Log::warning("Document ID {$this->documentId} no longer exists; aborting job.");
            return;
        }
        $this->pushProgress($document, 'Memulai pemrosesan dokumen...', 'Processing');

        $tempFile = null;
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'doc_');
            $signedUrl = URL::temporarySignedRoute('correction.original', now()->addMinutes(10), ['document' => $document->id]);
            
            Log::info('Worker fetching file via signed URL', [
                'document_id' => $document->id,
                'signed_url' => $signedUrl,
                'app_url' => config('app.url'),
            ]);
            
            $response = HttpFacade::withOptions(['timeout' => 60, 'sink' => $tempFile])->get($signedUrl);

            $status = method_exists($response, 'status') ? $response->status() : null;
            if (! ($response->successful() || $status === 200)) {
                $body = method_exists($response, 'body') ? $response->body() : null;
                Log::warning('Fallback download failed - non-200 status', ['document_id' => $document->id, 'status' => $status, 'body_snippet' => is_string($body) ? substr($body, 0, 500) : null]);
                @unlink($tempFile);
                $document->update(['upload_status' => 'Failed', 'details' => 'File tidak ditemukan oleh worker.']);
                return;
            }

            $contentType = $response->header('Content-Type');
            if ($contentType && stripos($contentType, 'application/pdf') === false && stripos($contentType, 'text/html') !== false) {
                 Log::warning('Fallback download returned HTML instead of PDF', [ 'document_id' => $document->id]);
                @unlink($tempFile);
                $document->update(['upload_status' => 'Failed', 'details' => 'Worker received HTML error page instead of PDF.']);
                return;
            }

            $file_path = $tempFile; 
            Log::info("Fallback download successful for Document ID {$document->id}, using temp file: {$tempFile}", ['document_id' => $document->id]);

            
        } catch (\Throwable $e) {
            Log::warning('Fallback download via signed URL failed: ' . $e->getMessage(), ['document_id' => $document->id, 'exception' => $e->getTraceAsString()]);
            if (!empty($tempFile) && file_exists($tempFile)) @unlink($tempFile);
            $document->update(['upload_status' => 'Failed', 'details' => 'File tidak ditemukan oleh worker.']);
            return;
        }

        try {
            
            try {
                $isPdf = false;
                if (!empty($file_path) && is_file($file_path) && is_readable($file_path)) {
                    $h = @fopen($file_path, 'rb');
                    if ($h !== false) {
                        $first = @fread($h, 5);
                        @fclose($h);
                        if ($first === '%PDF-' || (is_string($first) && strpos($first, '%PDF') === 0)) {
                            $isPdf = true;
                        }
                    }
                }
                if (! $isPdf) {
                    Log::error("Document Correction Failed for ID {$document->id}: Invalid PDF data: Missing `%PDF-` header.");
                    $document->update(['upload_status' => 'Failed', 'details' => 'Invalid PDF data: Missing %PDF header.']);
                    if (!empty($tempFile) && file_exists($tempFile)) @unlink($tempFile);
                    return;
                }
            } catch (\Throwable $e) {
                Log::warning('PDF header check failed: ' . $e->getMessage(), ['document_id' => $document->id]);
            }

            $parser = new Parser();
            $this->pushProgress($document, 'Membaca isi dokumen...');
            $pdf = $parser->parseFile($file_path);
            $original_text = trim($pdf->getText());

            if (empty($original_text)) {
                $document->update(['upload_status' => 'Failed', 'details' => 'Gagal mengekstrak teks dari PDF.']);
                if (!empty($tempFile) && file_exists($tempFile)) @unlink($tempFile);
                return;
            }

            $clean_text = mb_convert_encoding($original_text, 'UTF-8', 'UTF-8');
            $clean_text = preg_replace('/[[:cntrl:]]/', '', $clean_text);
            $original_text = $clean_text;
            
            $this->pushProgress($document, 'Mempersiapkan dokumen untuk dikoreksi...');

            $corrected_text = $this->correctTextWithGemini($original_text);

            if (str_starts_with($corrected_text, 'ERROR:')) {
                throw new \Exception($corrected_text);
            }

            // Validasi hasil tidak kosong dan cukup panjang
            if (empty($corrected_text) || mb_strlen($corrected_text, 'UTF-8') < 100) {
                throw new \Exception('Hasil koreksi terlalu pendek atau kosong');
            }

            // Cek apakah hasil terpotong (kurang dari 60% text original)
            $originalLen = mb_strlen($original_text, 'UTF-8');
            $correctedLen = mb_strlen($corrected_text, 'UTF-8');
            if ($correctedLen < ($originalLen * 0.6)) {
                Log::warning("Corrected text suspiciously short", [
                    'document_id' => $document->id,
                    'original' => $originalLen,
                    'corrected' => $correctedLen,
                    'ratio' => round(($correctedLen / $originalLen) * 100, 2) . '%'
                ]);
            }

            $document->original_text = $original_text;
            $document->corrected_text = $corrected_text;
            $document->upload_status = 'Completed';
            $this->pushProgress($document, 'Koreksi selesai.', 'Completed');
            $document->save();
            $document->fresh();

            if (!empty($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }

            Log::info("Document ID {$document->id} corrected successfully.");

        } catch (\Exception $e) {
            Log::error("Document Correction Failed for ID {$document->id}: " . $e->getMessage());
            if (!empty($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }
            $document->update(['upload_status' => 'Failed', 'details' => 'Pemrosesan gagal: ' . substr($e->getMessage(), 0, 250)]);
        }
    }

    private function correctTextWithGemini($text)
    {
        $jobStart = microtime(true);

        try {
            $cacheKey = 'doc_correction_' . sha1($text);
            if (Cache::has($cacheKey)) {
                Log::info("Document correction cache hit");
                return Cache::get($cacheKey);
            }

            $apiKey = env('GOOGLE_API_KEY');
            $modelName = 'gemini-2.5-flash';
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key=" . $apiKey;
            $timeoutDuration = 600;

            $textLen = mb_strlen($text, 'UTF-8');
            Log::info("Processing document correction: length={$textLen} chars");

            $document = Document::find($this->documentId);
            if (!$document) {
                return "ERROR: Document not found.";
            }

            // PROMPT SEDERHANA - fokus ke koreksi saja
            $prompt = "Koreksi tata bahasa dan ejaan bahasa Indonesia berikut. Jangan ubah struktur atau makna. Berikan hanya hasil koreksi:\n\n" . $text;

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ];

            $this->pushProgress($document, "Mengoreksi dokumen...");
            $response = Http::withOptions(['timeout' => $timeoutDuration])->post($url, $payload);

            if (!$response->successful()) {
                $status = method_exists($response, 'status') ? $response->status() : 'unknown';
                $errorBody = $response->body();
                Log::error("Gemini HTTP Error: status={$status}");
                
                if (str_contains($errorBody, 'too large') || str_contains($errorBody, 'REQUEST_TOO_LARGE')) {
                    return "ERROR: Teks terlalu besar untuk diproses sekaligus.";
                }
                
                return "ERROR: Gagal menghubungi API (Status: {$status})";
            }

            $extracted = null;
            try {
                $json = $response->json();
                if (!empty($json['candidates'][0]['content']['parts'][0]['text'])) {
                    $extracted = $json['candidates'][0]['content']['parts'][0]['text'];
                }
            } catch (\Throwable $jsonErr) {
                Log::error("JSON parsing failed: " . $jsonErr->getMessage());
                return "ERROR: Gagal membaca balasan dari API.";
            }

            if (empty($extracted)) {
                return "ERROR: API tidak memberikan hasil koreksi.";
            }

            $result = trim($extracted);

            // Validasi panjang
            $originalLength = mb_strlen($text, 'UTF-8');
            $resultLength = mb_strlen($result, 'UTF-8');
            $percentageComplete = ($resultLength / $originalLength) * 100;

            Log::info("Correction check", [
                'original' => $originalLength,
                'result' => $resultLength,
                'percentage' => round($percentageComplete, 2)
            ]);

            if ($percentageComplete < 60) {
                return "ERROR: Hasil tidak lengkap (hanya " . round($percentageComplete) . "%). Dokumen terlalu besar.";
            }

            // FORMATTING AGRESIF - SELALU dijalankan
            $this->pushProgress($document, "Memformat hasil...");
            $result = $this->formatCorrectedText($result);

            Cache::put($cacheKey, $result, now()->addDays(7));

            $totalTook = round(microtime(true) - $jobStart, 3);
            Log::info("Correction finished: {$totalTook}s");

            return $result;

        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return "ERROR: " . $e->getMessage();
        }
    }

    private function formatCorrectedText($text)
    {
        Log::info("Starting aggressive formatting v2");
        
        // Step 1: Bersihkan whitespace berlebih
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n+/', ' ', $text);
        $text = trim($text);
        
        // Step 2: Deteksi MAJOR HEADINGS (ALL CAPS dengan kata 2+)
        $text = preg_replace('/\b([A-Z][A-Z\s]{8,})\b/', "\n\n\n$1\n\n", $text);
        
        // Step 3: Deteksi numbered sections yang SANGAT SPESIFIK
        // Format: "4.2.3 Judul Bagian"
        $text = preg_replace('/(\d+\.\d+(?:\.\d+)?)\s+([A-Z][^\n.]{5,50})/', "\n\n$1 $2\n", $text);
        
        // Step 4: Deteksi list SEBELUM split kalimat
        // Numbered list dengan berbagai format
        $text = preg_replace('/\s+(\d+)\.\s+([A-Z])/u', "\n$1. $2", $text); // "1. Abc"
        $text = preg_replace('/\s+(\d+)\)\s+([A-Z])/u', "\n$1) $2", $text); // "1) Abc"
        $text = preg_replace('/\s+([a-z])\.\s+/u', "\n$1. ", $text); // "a. "
        $text = preg_replace('/\s+([a-z])\)\s+/u', "\n$1) ", $text); // "a) "
        
        // Bullet points
        $text = preg_replace('/\s*[•\-\*]\s+/u', "\n• ", $text);
        
        // Step 5: Split per LINE (karena sudah ada \n dari step 3-4)
        $lines = explode("\n", $text);
        $formatted = '';
        $paragraphSentences = 0;
        $inList = false;
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Deteksi apakah line ini adalah list item
            $isBullet = preg_match('/^[•\-\*]/', $line);
            $isNumberedList = preg_match('/^(\d+[\.\)]|[a-z][\.\)])\s/', $line);
            $isListItem = $isBullet || $isNumberedList;
            
            // Deteksi heading
            $upperCount = preg_match_all('/[A-Z]/', $line);
            $totalLetters = preg_match_all('/[a-zA-Z]/', $line);
            $isHeading = ($totalLetters > 5 && ($upperCount / $totalLetters) > 0.7) || 
                        preg_match('/^\d+\.\d+/', $line); // Section number
            
            if ($isListItem) {
                // List item - beri spacing jika baru mulai list
                if (!$inList && $paragraphSentences > 0) {
                    $formatted .= "\n"; // Extra space sebelum list dimulai
                }
                $formatted .= $line . "\n";
                $inList = true;
                $paragraphSentences = 0;
            } elseif ($isHeading) {
                // Heading
                if ($inList) {
                    $formatted .= "\n"; // Extra space setelah list selesai
                }
                $formatted .= "\n" . $line . "\n\n";
                $inList = false;
                $paragraphSentences = 0;
            } else {
                // Kalimat biasa
                if ($inList) {
                    $formatted .= "\n"; // Extra space setelah list selesai
                    $inList = false;
                }
                
                // Split per kalimat
                $sentences = preg_split('/(?<=[.!?])\s+(?=[A-Z])/u', $line, -1, PREG_SPLIT_NO_EMPTY);
                
                foreach ($sentences as $sentence) {
                    $sentence = trim($sentence);
                    if (empty($sentence)) continue;
                    
                    $formatted .= $sentence . "\n";
                    $paragraphSentences++;
                    
                    // Paragraf baru setiap 3 kalimat
                    if ($paragraphSentences >= 3) {
                        $formatted .= "\n";
                        $paragraphSentences = 0;
                    }
                }
            }
        }
        
        // Step 6: Cleanup final
        // Hilangkan 3+ newlines jadi max 2
        $formatted = preg_replace('/\n{3,}/', "\n\n", $formatted);
        
        // Trim lines
        $lines = explode("\n", $formatted);
        $lines = array_map('trim', $lines);
        $formatted = implode("\n", $lines);
        
        $formatted = trim($formatted);
        
        Log::info("Formatting complete v2", [
            'line_breaks' => substr_count($formatted, "\n"),
            'paragraphs' => substr_count($formatted, "\n\n"),
            'bullets' => substr_count($formatted, "\n•"),
            'numbered' => preg_match_all('/\n\d+\.\s/', $formatted)
        ]);
        
        return $formatted;
    }

    private function pushProgress(Document $document, string $message, string $status = null)
    {
        try {
            $log = $document->progress_log ?? [];
            if (!is_array($log)) $log = [];
            $entry = ['ts' => now()->toDateTimeString(), 'message' => $message];
            $log[] = $entry;
            if (count($log) > 50) $log = array_slice($log, -50);

            $update = ['progress_log' => $log, 'details' => $message];
            if (!is_null($status)) {
                $update['upload_status'] = $status;
            }

            $document->update($update);
        } catch (\Throwable $e) {
            Log::warning("pushProgress failed for Document ID {$document->id}: " . $e->getMessage());
        }
    }
}