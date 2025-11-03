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
<<<<<<< HEAD
use Illuminate\Http\Client\Pool;
=======
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
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
        // Always operate on the live DB record (in case it was deleted while queued)
        $document = Document::find($this->documentId);
        if (! $document) {
            Log::warning("Document ID {$this->documentId} no longer exists; aborting job.");
            return;
        }
<<<<<<< HEAD

        // mark started (helps the UI know processing began and provides initial details)
=======
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
        $this->pushProgress($document, 'Memulai pemrosesan dokumen...', 'Processing');

        // Resolve file location using the configured filesystem disk. In deployments like Railway
        // the app and worker don't share local disk, so we must support remote disks (s3) by
        // streaming the file to a temporary local path for processing.
        $fileLocation = $document->file_location;

        // Determine which disk actually contains the file. We try these in order:
        // 1. If the document record stores a disk (future-proof), try that.
        // 2. Iterate configured disks and pick the first one where the file exists.
        // 3. Fall back to the default disk.
        // For this deployment the worker should always fetch the original file from
        // the web server via a temporary signed URL rather than probing local
        // filesystem disks. This avoids cross-container filesystem assumptions.
        $disk = config('filesystems.default') ?: 'public';
        Log::info("Worker will fetch original via signed URL for Document ID {$document->id}");

        // Helper: stream the remote file into a temp file so downstream parsing
        // always operates on a local path. Caller must unlink the temp file when done.
        $tempFile = null;
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'doc_');
            $signedUrl = URL::temporarySignedRoute('correction.original', now()->addMinutes(10), ['document' => $document->id]);
            
            Log::info('Worker fetching file via signed URL', [
                'document_id' => $document->id,
                'signed_url' => $signedUrl,
                'app_url' => config('app.url'),
                'route_name' => 'correction.original',
                'expires_at' => now()->addMinutes(10)->timestamp
            ]);
            
            $response = HttpFacade::withOptions(['timeout' => 60, 'sink' => $tempFile])->get($signedUrl);

            $status = method_exists($response, 'status') ? $response->status() : null;
            $contentType = $response->header('Content-Type');
            $contentLength = $response->header('Content-Length');
            
            Log::info('Fallback download response', [
                'document_id' => $document->id,
                'status' => $status,
                'content_type' => $contentType,
                'content_length' => $contentLength,
                'temp_file_size' => file_exists($tempFile) ? filesize($tempFile) : 0
            ]);

            if (! ($response->successful() || $status === 200)) {
                $body = method_exists($response, 'body') ? $response->body() : null;
                Log::warning('Fallback download failed - non-200 status', ['document_id' => $document->id, 'status' => $status, 'body_snippet' => is_string($body) ? substr($body, 0, 500) : null]);
                @unlink($tempFile);
                $document->update(['upload_status' => 'Failed', 'details' => 'File tidak ditemukan oleh worker.']);
                return;
            }

            // Check if response is actually a PDF by content-type and file header
            if ($contentType && stripos($contentType, 'application/pdf') === false && stripos($contentType, 'text/html') !== false) {
                Log::warning('Fallback download returned HTML instead of PDF', [
                    'document_id' => $document->id,
                    'content_type' => $contentType,
                    'first_bytes' => file_exists($tempFile) ? bin2hex(substr(file_get_contents($tempFile, false, null, 0, 16), 0, 16)) : null
                ]);
                @unlink($tempFile);
                $document->update(['upload_status' => 'Failed', 'details' => 'Worker received HTML error page instead of PDF.']);
                return;
            }

            $file_path = $tempFile; // use the downloaded file
            Log::info("Fallback download successful for Document ID {$document->id}, using temp file: {$tempFile}", ['document_id' => $document->id]);

            // If the temp file has a MIME type of PDF but no .pdf extension, rename it
            try {
                if (function_exists('finfo_open')) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = @finfo_file($finfo, $file_path);
                    finfo_close($finfo);
                } else {
                    $mime = null;
                }

                $ext = pathinfo($file_path, PATHINFO_EXTENSION);
                if (strtolower($mime) === 'application/pdf' && strtolower($ext) !== 'pdf') {
                    $pdfPath = $file_path . '.pdf';
                    if (@rename($file_path, $pdfPath)) {
                        $file_path = $pdfPath;
                        $tempFile = $pdfPath; // ensure cleanup removes the renamed file
                        Log::info('Renamed temp download to have .pdf extension', ['document_id' => $document->id, 'new_path' => $pdfPath]);
                    } else {
                        Log::warning('Failed to rename temp file to .pdf extension', ['document_id' => $document->id, 'path' => $file_path]);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Could not examine/rename downloaded temp file: ' . $e->getMessage(), ['document_id' => $document->id]);
            }
        } catch (\Throwable $e) {
            Log::warning('Fallback download via signed URL failed: ' . $e->getMessage(), ['document_id' => $document->id, 'exception' => $e->getTraceAsString()]);
            if (!empty($tempFile) && file_exists($tempFile)) @unlink($tempFile);
            $document->update(['upload_status' => 'Failed', 'details' => 'File tidak ditemukan oleh worker.']);
            return;
        }

        try {
            // DEBUG: surface the resolved local path and basic file checks so we can
            // diagnose "file not found by worker" issues in logs quickly.
            try {
                $debugExists = isset($file_path) && file_exists($file_path);
                $debugReadable = isset($file_path) && is_readable($file_path);
            } catch (\Throwable $t) {
                $debugExists = false;
                $debugReadable = false;
            }

            Log::info('Debug file path resolved', [
                'document_id' => $document->id,
                'disk' => $disk ?? null,
                'file_location' => $fileLocation ?? null,
                'file_path' => $file_path ?? null,
                'file_exists' => $debugExists,
                'is_readable' => $debugReadable,
            ]);

            // Quick validation: ensure the resolved file looks like a PDF by
            // checking the leading bytes for the "%PDF-" signature. This helps
            // detect cases where an HTML error page or truncated response was
            // saved to disk (common with signed-URL 502/502 pages) which would
            // otherwise cause the PDF parser to fail without an easy artifact.
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
                    // Save a small debug sample (first 1KB) to local storage for
                    // debugging. Do not fail noisily if the save itself errors.
                    try {
                        $sample = @file_get_contents($file_path, false, null, 0, 1024);
                        if ($sample !== false && !empty($sample)) {
                            $sampleName = 'debug_samples/document_' . $document->id . '_' . time() . '.sample.txt';
                            // Always attempt to save locally first so the worker keeps a copy
                            try {
                                Storage::disk('local')->put($sampleName, $sample);
                                Log::warning('PDF header missing; saved debug sample locally', ['document_id' => $document->id, 'sample' => $sampleName]);
                            } catch (\Throwable $e) {
                                Log::warning('PDF header missing; failed to save local debug sample: ' . $e->getMessage(), ['document_id' => $document->id]);
                            }

                            // S3/object-storage persistence intentionally removed —
                            // we only persist debug samples locally to avoid remote
                            // dependencies in this deployment.
                        }
                    } catch (\Throwable $_) {
                        // ignore sample saving failures
                    }

                    Log::error("Document Correction Failed for ID {$document->id}: Invalid PDF data: Missing %PDF- header.");
                    $document->update(['upload_status' => 'Failed', 'details' => 'Invalid PDF data: Missing %PDF header.']);

                    // cleanup temporary file if we created one
                    if (!empty($tempFile) && file_exists($tempFile)) {
                        @unlink($tempFile);
                    }

                    return;
                }
            } catch (\Throwable $e) {
                Log::warning('PDF header check failed: ' . $e->getMessage(), ['document_id' => $document->id]);
            }

            $parser = new Parser();
            // update progress for parsing
            $this->pushProgress($document, 'Membaca isi dokumen...');
            $pdf = $parser->parseFile($file_path);
            $original_text = trim($pdf->getText());

            if (empty($original_text)) {
                $document->update(['upload_status' => 'Failed', 'details' => 'Gagal mengekstrak teks dari PDF.']);
                return;
            }

<<<<<<< HEAD
            // Log PDF extraction stats for verification
            $pageCount = count($pdf->getPages());
            $originalLength = mb_strlen($original_text, 'UTF-8');
            Log::info('PDF extraction complete', [
                'document_id' => $document->id,
                'page_count' => $pageCount,
                'original_text_length' => $originalLength,
                'first_100_chars' => mb_substr($original_text, 0, 100, 'UTF-8'),
                'last_100_chars' => mb_substr($original_text, -100, 100, 'UTF-8')
            ]);

=======
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
            $clean_text = mb_convert_encoding($original_text, 'UTF-8', 'UTF-8');
            $clean_text = preg_replace('/[[:cntrl:]]/', '', $clean_text);
            $original_text = $clean_text;
            
            // Verify no text was lost during cleaning
            $cleanedLength = mb_strlen($original_text, 'UTF-8');
            if ($cleanedLength < $originalLength * 0.9) {
                Log::warning('Significant text loss during cleaning', [
                    'document_id' => $document->id,
                    'original_length' => $originalLength,
                    'cleaned_length' => $cleanedLength,
                    'loss_percentage' => round((1 - $cleanedLength / $originalLength) * 100, 2)
                ]);
            }
            
            // indicate we're preparing chunks / checking cache
            $this->pushProgress($document, 'Mempersiapkan dokumen untuk dikoreksi...');

<<<<<<< HEAD
            // === PERUBAHAN DI SINI ===
            // Memanggil method Ollama, bukan Gemini lagi
            $corrected_text = $this->correctTextWithOllama($original_text);
            // === AKHIR PERUBAHAN ===
=======
            $corrected_text = $this->correctTextWithGemini($original_text);
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675

            if (str_starts_with($corrected_text, 'ERROR:')) {
                throw new \Exception($corrected_text);
            }

<<<<<<< HEAD
            // persist results and mark completed
=======
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

>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
            $document->original_text = $original_text;
            $document->corrected_text = $corrected_text;
            $document->upload_status = 'Completed';
            $this->pushProgress($document, 'Koreksi selesai.', 'Completed');
            $document->save();
            $document->fresh();

            // cleanup temporary file if we created one from remote storage
            if (!empty($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }

            Log::info("Document ID {$document->id} corrected successfully.");

        } catch (\Exception $e) {
            Log::error("Document Correction Failed for ID {$document->id}: " . $e->getMessage());
            // cleanup temp file if used
            if (!empty($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }

            $document->update(['upload_status' => 'Failed', 'details' => 'Pemrosesan gagal: ' . substr($e->getMessage(), 0, 250)]);
        }
    }

    /**
     * ===================================================================
     * METHOD BARU UNTUK OLLAMA
     * Mengoreksi teks menggunakan API Ollama (Senopati)
     * ===================================================================
     */
    private function correctTextWithOllama($text)
    {
        $jobStart = microtime(true);

        try {
<<<<<<< HEAD
            $cacheKey = 'doc_correction_ollama_' . sha1($text); // Cache key khusus Ollama
=======
            $cacheKey = 'doc_correction_' . sha1($text);
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
            if (Cache::has($cacheKey)) {
                Log::info("Document correction cache hit");
                return Cache::get($cacheKey);
            }

<<<<<<< HEAD
            // --- INI ADALAH LOGIKA OLLAMA ---
            $baseUrl = env('OLLAMA_API_BASE_URL', 'https://senopati.its.ac.id/senopati-lokal-dev');
            $modelName = env('OLLAMA_API_MODEL'); // Ambil dari .env
            $apiKey = env('OLLAMA_API_KEY', null); // Ambil dari .env (jika ada)
            
            $url = rtrim($baseUrl, '/') . '/generate';

            if (empty($modelName)) {
                Log::error('OLLAMA_API_MODEL tidak diatur di .env. Membatalkan job.');
                return "ERROR: OLLAMA_API_MODEL not configured.";
            }
=======
            $apiKey = env('GOOGLE_API_KEY');
            $modelName = 'gemini-2.5-flash';
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key=" . $apiKey;
            $timeoutDuration = 600;
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675

            $timeoutDuration = 600; // 10 minutes per request

            // --- (Logika Chunking tetap sama) ---
            $maxLength = 8000;
            $textLen = mb_strlen($text, 'UTF-8');
<<<<<<< HEAD
            $chunks = [];
            for ($offset = 0; $offset < $textLen; $offset += $maxLength) {
                $chunkText = mb_substr($text, $offset, $maxLength, 'UTF-8');
                $chunks[] = $chunkText;
            }
            $chunkCount = count($chunks);
            
            Log::info("Processing document correction (OLLAMA): length={$textLen} chars, chunks={$chunkCount}", [
                'document_id' => $this->documentId,
                'model' => $modelName,
                'api_url' => $url,
            ]);

            // --- (Logika Cache Check tetap sama) ---
            $correctedChunks = array_fill(0, $chunkCount, null);
            $toSend = [];
            $cacheHits = 0;
            foreach ($chunks as $i => $chunk) {
                $chunkKey = 'doc_chunk_ollama_' . sha1($chunk); // Cache key khusus Ollama
                if (Cache::has($chunkKey)) {
                    $correctedChunks[$i] = Cache::get($chunkKey);
                    $cacheHits++;
                } else {
                    $toSend[$i] = $chunk;
                }
            }
            Log::info("Chunk cache hits: {$cacheHits}/{$chunkCount}");
            $document = Document::find($this->documentId);
            if (! $document) {
                Log::warning("Document ID {$this->documentId} not found when updating chunk/cache details; aborting.");
                return implode("\n\n", $correctedChunks);
            }
            $this->pushProgress($document, "Memeriksa dokumen ({$chunkCount} bagian)...");
            if (empty($toSend)) {
                $result = implode("\n\n", $correctedChunks);
                Cache::put($cacheKey, $result, now()->addDays(7));
                Log::info('All chunks served from cache; returning assembled result quickly.');
                return $result;
            }
            // --- (Akhir Logika Cache Check) ---


            // --- (Logika Batching tetap sama) ---
            $concurrency = 6; 
            $indices = array_keys($toSend);
            $batches = array_chunk($indices, $concurrency);
            $totalBatches = count($batches);
            $batchNumber = 0;

            foreach ($batches as $batch) {
                $batchNumber++;
                Log::info("Sending batch {$batchNumber}/{$totalBatches} (size=" . count($batch) . ") to Ollama...");
                
                $document = Document::find($this->documentId);
                if (! $document) {
                    Log::warning("Document ID {$this->documentId} not found before sending batch {$batchNumber}; aborting.");
                    return implode("\n\n", $correctedChunks);
=======
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
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
                }
                $this->pushProgress($document, "Mengoreksi bagian {$batchNumber} dari {$totalBatches}...");

<<<<<<< HEAD
                $batchChunks = [];
                foreach ($batch as $idx) {
                    $batchChunks[] = ['index' => $idx, 'text' => $toSend[$idx]];
                }

                $responses = [];
                try {
                    Log::info("About to call Http::pool for batch {$batchNumber}", [
                        'document_id' => $this->documentId,
                        'batch_size' => count($batchChunks),
                        'timeout' => $timeoutDuration
                    ]);

                    // --- POOL DENGAN PAYLOAD OLLAMA ---
                    $poolResponses = Http::pool(function (Pool $pool) use ($url, $batchChunks, $timeoutDuration, $modelName, $apiKey) {
                        $calls = [];
                        foreach ($batchChunks as $b) {
                            $prompt = "Perbaiki tata bahasa dan ejaan dalam bahasa Indonesia tanpa mengubah makna berikut. Jangan ubah format tata letak teksnya. Berikan dalam bentuk teks saja, dan hanya berikan teks hasilnya.\n\n" . $b['text'];
                            
                            // Payload untuk Ollama
                            $payload = [
                                'model' => $modelName,
                                'prompt' => $prompt,
                                'stream' => false 
                            ];
                            
                            $request = $pool->withOptions(['timeout' => $timeoutDuration]);

                            if (!empty($apiKey)) {
                                $request->withHeaders(['Authorization' => 'Bearer ' . $apiKey]); // Sesuaikan jika autentikasi beda
                            }

                            $calls[] = $request->post($url, $payload);
                        }
                        return $calls;
                    });
                    
                    // (Logika konversi response pool tetap sama)
                    foreach ($poolResponses as $idx => $poolResp) {
                        if ($poolResp instanceof \Throwable) {
                            Log::error("Pool response {$idx} is exception", ['class' => get_class($poolResp), 'message' => $poolResp->getMessage()]);
                            $responses[] = new class {
                                public function successful() { return false; } public function status() { return 0; }
                                public function body() { return 'pool request threw exception'; } public function json() { return []; }
                            };
                        } else {
                            $responses[] = $poolResp;
                        }
                    }
                    
                } catch (\Throwable $t) {
                    Log::error("Http::pool (Ollama) failed on batch {$batchNumber}: " . $t->getMessage());
                    // Fallback ke sekuensial
                    $responses = [];
                    foreach ($batchChunks as $b) {
                        try {
                            // Panggil method retry yang baru
                            $resp = $this->sendOllamaChunkWithRetries($url, $b['text'], $timeoutDuration, $modelName, $apiKey);
                            $responses[] = $resp;
                        } catch (\Throwable $e) {
                            Log::error("sendOllamaChunkWithRetries threw exception for chunk {$b['index']}: " . $e->getMessage());
                            $responses[] = new class {
                                public function successful() { return false; } public function status() { return 0; }
                                public function body() { return 'exception during retry'; } public function json() { return []; }
                            };
                        }
                    }
                }

                // --- PARSING RESPONSE OLLAMA ---
                Log::info("Processing responses for batch {$batchNumber}", ['document_id' => $this->documentId, 'response_count' => count($responses)]);
                
                foreach (array_values($responses) as $k => $response) {
                    $b = $batchChunks[$k];
                    $index = $b['index'];
                    
                    // (Error handling standar tetap sama)
                    if ($response instanceof \Throwable || ! is_object($response) || ! method_exists($response, 'successful')) {
                         Log::error("Invalid response object for chunk {$index}", ['type' => is_object($response) ? get_class($response) : gettype($response)]);
                        $correctedChunks[$index] = "[GAGAL KOREKSI BAGIAN {$index}]";
                        continue;
                    }

                    if (! $response->successful()) {
                        $status = method_exists($response, 'status') ? $response->status() : 'unknown';
                        Log::error("Ollama HTTP Error (Chunk {$index}): status={$status} body=" . substr($response->body(), 0, 500));
                        $correctedChunks[$index] = "[GAGAL KOREKSI BAGIAN {$index}]";
                        continue;
                    }

                    // Ekstrak teks dari response Ollama
                    try {
                        $body = method_exists($response, 'body') ? $response->body() : (string) $response;
                        $extracted = null;
                        try {
                            $json = $response->json();
                            Log::info("Ollama response JSON for chunk {$index}", ['document_id' => $this->documentId, 'json_keys' => is_array($json) ? array_keys($json) : []]);
                            
                            // Standar Ollama adalah 'response'
                            if (!empty($json['response'])) {
                                $extracted = $json['response'];
                                Log::info("Extracted via Ollama 'response' key for chunk {$index}");
                            }

                        } catch (\Throwable $jsonErr) {
                            Log::error("JSON parsing failed for chunk {$index}: " . $jsonErr->getMessage());
                        }

                        if (empty($extracted)) {
                            Log::warning("No text extracted from JSON, using raw body for chunk {$index}", ['body_preview' => substr($body, 0, 200)]);
                            $extracted = trim($body);
                        }
                        
                        $correctedChunks[$index] = trim($extracted);
                        Log::info("Successfully processed chunk {$index}", ['document_id' => $this->documentId, 'extracted_length' => mb_strlen($correctedChunks[$index], 'UTF-8')]);

                        // Cache chunk
                        try {
                            $chunkKey = 'doc_chunk_ollama_' . sha1($b['text']);
                            Cache::put($chunkKey, $correctedChunks[$index], now()->addDays(7));
                        } catch (\Throwable $_) { /* ignore cache failures */ }

                    } catch (\Throwable $t) {
                        Log::warning("Failed to parse Ollama response for chunk {$index}: " . $t->getMessage());
                        $correctedChunks[$index] = "[GAGAL KOREKSI BAGIAN {$index}]";
                    }
                }
            }

            // --- (Logika Assembly/Penggabungan Hasil tetap sama) ---
            $document = Document::find($this->documentId);
            if (! $document) {
                Log::warning("Document ID {$this->documentId} not found before assembling; aborting.");
                return implode("\n\n", $correctedChunks);
            }
            $this->pushProgress($document, 'Menggabungkan hasil koreksi...');
            $result = implode("\n\n", $correctedChunks);
            
            // (Logging verifikasi chunk tetap sama)
            $nullChunks = 0; $failedChunks = 0;
            foreach ($correctedChunks as $idx => $chunk) {
                if ($chunk === null) $nullChunks++;
                if (is_string($chunk) && strpos($chunk, '[GAGAL KOREKSI BAGIAN') === 0) $failedChunks++;
            }
            Log::info("Document correction assembly complete", [
                'document_id' => $this->documentId, 'total_chunks' => $chunkCount,
                'null_chunks' => $nullChunks, 'failed_chunks' => $failedChunks,
                'result_length' => mb_strlen($result, 'UTF-8'), 'original_length' => $textLen
            ]);
            
            Cache::put($cacheKey, $result, now()->addDays(7));

            $totalTook = round(microtime(true) - $jobStart, 3);
            Log::info("Document correction (Ollama) finished: chunks={$chunkCount}, total_time={$totalTook}s");
=======
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
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675

            return $result;

        } catch (\Exception $e) {
<<<<<<< HEAD
            Log::error('Ollama Request Exception (Job): ' . $e->getMessage());
=======
            Log::error('Gemini Exception: ' . $e->getMessage());
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675
            return "ERROR: " . $e->getMessage();
        }
    }

<<<<<<< HEAD
    /**
     * ===================================================================
     * METHOD BARU UNTUK OLLAMA
     * Mengirim 1 chunk ke Ollama dengan retry
     * ===================================================================
     */
    private function sendOllamaChunkWithRetries(string $url, string $text, int $timeoutDuration, string $modelName, ?string $apiKey)
    {
        $attempts = 0;
        $maxAttempts = 2;
        $lastResponse = null;
=======
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
>>>>>>> a6699e0a336590c48ba352a76c02142827e87675

        while ($attempts < $maxAttempts) {
            $attempts++;
            try {
                $prompt = "Perbaiki tata bahasa dan ejaan dalam bahasa Indonesia tanpa mengubah makna berikut. Jangan ubah format tata letak teksnya. Berikan dalam bentuk teks saja, dan hanya berikan teks hasilnya.\n\n" . $text;

                // Payload untuk Ollama
                $payload = [
                    'model' => $modelName,
                    'prompt' => $prompt,
                    'stream' => false
                ];

                $request = Http::withOptions(['timeout' => $timeoutDuration]);

                if (!empty($apiKey)) {
                    $request->withHeaders(['Authorization' => 'Bearer ' . $apiKey]); // Sesuaikan jika autentikasi beda
                }

                $response = $request->post($url, $payload);
                
                if ($response->successful()) {
                    return $response;
                }
                $lastResponse = $response;
                Log::warning("Chunk request (Ollama) attempt {$attempts} failed (status=" . $response->status() . ").");
            } catch (\Throwable $t) {
                Log::warning("Chunk request (Ollama) attempt {$attempts} exception: " . $t->getMessage());
            }

            sleep(1);
        }

        if ($lastResponse) {
            return $lastResponse;
        }

        // Buat response error palsu
        return new class {
            public function successful() { return false; }
            public function status() { return 0; }
            public function body() { return 'no-response'; }
            public function json() { return []; }
        };
    }

    /**
     * Append a progress entry to the document's progress_log and update details.
     * This is best-effort and will not throw if the document is gone.
     */
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