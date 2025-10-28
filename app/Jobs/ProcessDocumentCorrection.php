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
// use Illuminate\Http\Client\Pool;
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

            // ... (Logika logging PDF extraction & cleaning text tetap sama) ...
            $clean_text = mb_convert_encoding($original_text, 'UTF-8', 'UTF-8');
            $clean_text = preg_replace('/[[:cntrl:]]/', '', $clean_text);
            $original_text = $clean_text;
            
            $this->pushProgress($document, 'Mempersiapkan dokumen untuk dikoreksi...');

            // Memanggil method 'correctTextWithGemini' yang sudah disederhanakan
            $corrected_text = $this->correctTextWithGemini($original_text);

            if (str_starts_with($corrected_text, 'ERROR:')) {
                throw new \Exception($corrected_text);
            }

            // ... (Logika menyimpan hasil & update status 'Completed' tetap sama) ...
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
        // Start timing for diagnostics
        $jobStart = microtime(true);

        try {
            // Cache check untuk seluruh teks
            $cacheKey = 'doc_correction_' . sha1($text);
            if (Cache::has($cacheKey)) {
                Log::info("Document correction cache hit for full document (key={$cacheKey}). Returning cached result.");
                return Cache::get($cacheKey);
            }

            // Ambil info API
            $apiKey = env('GOOGLE_API_KEY');
            $modelName = 'gemini-2.5-flash'; // Pastikan nama model ini benar
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key=" . $apiKey;

            // Timeout panjang (10 menit) untuk 1 request besar
            $timeoutDuration = 600; 

            $textLen = mb_strlen($text, 'UTF-8');
            Log::info("Processing document correction: length={$textLen} chars, 1 chunk (full text)", [
                'document_id' => $this->documentId,
                'text_length' => $textLen,
            ]);

            // Update progress di UI
            $document = Document::find($this->documentId);
            if (! $document) {
                Log::warning("Document ID {$this->documentId} not found when updating progress; aborting.");
                return "ERROR: Document not found.";
            }
            $this->pushProgress($document, "Mengoreksi seluruh dokumen (1 bagian)...");

            // Buat 1 payload untuk seluruh teks
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Perbaiki tata bahasa dan ejaan dalam bahasa Indonesia tanpa mengubah makna berikut. Jangan ubah format tata letak teksnya. Berikan dalam bentuk teks saja, dan hanya berikan teks hasilnya.\n\n" . $text]
                        ]
                    ]
                ]
            ];

            // Kirim 1 request HTTP
            $response = Http::withOptions(['timeout' => $timeoutDuration])->post($url, $payload);

            // Handle jika request gagal
            if (! $response->successful()) {
                $status = method_exists($response, 'status') ? $response->status() : 'unknown';
                $errorBody = $response->body();
                Log::error("Gemini HTTP Error (Full Text): status={$status} body=" . substr($errorBody, 0, 500));
                
                // Cek error spesifik jika teks terlalu besar
                if (str_contains($errorBody, '400 Bad Request') || str_contains($errorBody, 'too large') || str_contains($errorBody, 'REQUEST_TOO_LARGE')) {
                    return "ERROR: Teks terlalu besar untuk diproses sekaligus.";
                }
                
                return "ERROR: Gagal menghubungi API (Status: {$status})";
            }

            // Ekstrak hasil dari 1 response
            $extracted = null;
            try {
                $json = $response->json();
                Log::info("Gemini response JSON (Full Text)", [
                    'document_id' => $this->documentId,
                    'has_candidates' => isset($json['candidates']),
                ]);
                
                if (!empty($json['candidates'][0]['content']['parts'][0]['text'])) {
                    $extracted = $json['candidates'][0]['content']['parts'][0]['text'];
                    Log::info("Extracted via candidates[0].content.parts[0].text (Full Text)");
                }

            } catch (\Throwable $jsonErr) {
                Log::error("JSON parsing failed (Full Text): " . $jsonErr->getMessage());
                return "ERROR: Gagal membaca balasan dari API.";
            }

            if (empty($extracted)) {
                Log::warning("No text extracted from JSON (Full Text)");
                return "ERROR: API tidak memberikan hasil koreksi.";
            }

            $result = trim($extracted);

            // Cache hasil lengkapnya
            Cache::put($cacheKey, $result, now()->addDays(7));

            $totalTook = round(microtime(true) - $jobStart, 3);
            Log::info("Document correction finished (Full Text): total_time={$totalTook}s");

            return $result;

        } catch (\Exception $e) {
            Log::error('Gemini Request Exception (Job): ' . $e->getMessage());
            return "ERROR: " . $e->getMessage();
        }
    }

    // private function sendChunkWithRetries(string $url, string $text, int $timeoutDuration)
    // {
    //     return new class {
    //         public function successful() { return false; }
    //         public function status() { return 0; }
    //         public function body() { return 'no-response'; }
    //         public function json() { return []; }
    //     };
    // }

    private function pushProgress(Document $document, string $message, string $status = null)
    {
        try {
            $log = $document->progress_log ?? [];
            if (!is_array($log)) $log = [];
            $entry = ['ts' => now()->toDateTimeString(), 'message' => $message];
            $log[] = $entry;
            // keep last 50 entries only
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