<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\DocumentChapter;
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
use Illuminate\Support\Facades\DB;

class ProcessDocumentCorrection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $document;
    protected $documentId;
    public $timeout = 900;

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

        $document->update([
            'original_text' => null,
            'corrected_text' => null,
        ]);

        $this->pushProgress($document, 'Memulai pemrosesan dokumen...', 'Processing');

        $tempFile = null;
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'doc_');
            $signedUrl = URL::temporarySignedRoute('correction.original', now()->addMinutes(10), ['document' => $document->id]);
            $response = HttpFacade::withOptions(['timeout' => 60, 'sink' => $tempFile])->get($signedUrl);

            if (!$response->successful()) {
                 throw new \Exception('Gagal mengunduh file via signed URL. Status: ' . $response->status());
            }
            $file_path = $tempFile; 
            Log::info("File downloaded to temp path: {$file_path}", ['document_id' => $document->id]);

        } catch (\Throwable $e) {
            Log::warning('File download via signed URL failed: ' . $e->getMessage(), ['document_id' => $document->id]);
            if (!empty($tempFile) && file_exists($tempFile)) @unlink($tempFile);
            $document->update(['upload_status' => 'Failed', 'details' => 'File tidak ditemukan oleh worker.']);
            return;
        }

        try {
            // Cek PDF Header
            try {
                $h = @fopen($file_path, 'rb');
                $first = @fread($h, 5);
                @fclose($h);
                if (strpos($first, '%PDF') === false) { 
                     throw new \Exception('Invalid PDF data: Missing %PDF header.');
                }
            } catch (\Throwable $e) {
                Log::warning('PDF header check failed: ' . $e->getMessage(), ['document_id' => $document->id]);
            }

            $parser = new Parser();
            $this->pushProgress($document, 'Membaca dan mempartisi dokumen (per halaman)...');
            
            $pdf = $parser->parseFile($file_path);
            $pages = $pdf->getPages();
            Log::info("Total pages found: " . count($pages), ['document_id' => $this->documentId]);

            $chapters_data = $this->splitByBab($pages); 
            
            // Logika "Bukan File TA" (No_Chapters)
            if (empty($chapters_data)) {
                 Log::warning("No valid chapters found for Document ID {$this->documentId}. Marking as 'No_Chapters'.");
                 $document->update([
                     'upload_status' => 'No_Chapters', 
                     'details' => 'Dokumen ini tidak dapat dipecah. Pastikan file yang diunggah adalah Tugas Akhir (TA).'
                 ]);
                 
                 if (!empty($tempFile) && file_exists($tempFile)) @unlink($tempFile);
                 return;
            }

            $totalChapters = count($chapters_data);
            Log::info("Document {$this->documentId} split into {$totalChapters} chapters. Saving to DB...");

            DocumentChapter::where('document_id', $this->documentId)->delete();

            DB::transaction(function () use ($chapters_data, $document, $totalChapters) {
                $createdChapters = 0;
                foreach ($chapters_data as $index => $chapter) {
                    if (empty($chapter['isi'])) continue;
                    
                    DocumentChapter::create([
                        'document_id' => $this->documentId,
                        'chapter_title' => $chapter['judul'],
                        'chapter_order' => $index + 1,
                        'original_text' => $chapter['isi'],
                        'status' => 'Pending',
                    ]);
                    $this->pushProgress($document, "Menyimpan {$chapter['judul']}...");
                    $createdChapters++;
                }

                if ($createdChapters === 0) {
                    throw new \Exception('Gagal menyimpan bab yang valid setelah pemrosesan.');
                }

                $document->upload_status = 'Ready'; 
                $document->details = "Dokumen berhasil dipecah menjadi {$createdChapters} bab dan siap untuk dikoreksi.";
                $this->pushProgress($document, 'Dokumen siap.', 'Ready');
                $document->save();
            });

            if (!empty($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }

            Log::info("Document ID {$this->documentId} split successfully (page-by-page).");

        } catch (\Exception $e) {
            Log::error("Document Splitting Failed for ID {$this->documentId}: " . $e->getMessage());
            if (!empty($tempFile) && file_exists($tempFile)) {
                @unlink($tempFile);
            }
            $document->update(['upload_status' => 'Failed', 'details' => 'Pemecahan gagal: ' . substr($e->getMessage(), 0, 250)]);
        }
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

    // Fungsi cleanPageText v6.1 (sudah benar)
    private function cleanPageText(string $text): string
    {
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        $text = preg_replace('/[^\pL\pN\pP\pS\pZ\s]/u', '', $text);
        $text = preg_replace('/(\w)-\n(\w)/', '$1$2', $text); 
        $text = preg_replace('/\n{3,}/', "\n\n", $text); 
        return trim($text);
    }


    // =================================================================
    // == FUNGSI SPLITBYBAB (v12 - Perbaikan Anti-ToC & Cyrillic) ==
    // =================================================================
    private function splitByBab(array $pages): array
    {
        try {
            $chapters = [];
            $currentChapterContent = "";
            $currentChapterTitle = "";
            $recording = false;

            // ==================
            // PERBAIKAN REGEX v12
            // ==================
            
            // Pola nomor Bab: Romawi (I-X), Cyrillic (ІШ ATAU IІI), atau Angka (1-10, dst)
            $roman = 'X|IX|IV|V?I{0,3}'; // I, II, III, IV, V, VI, VII, VIII, IX, X
            $arabic = '\d+'; // 1, 2, 3...
            $cyrillic = '(?:ІШ|ІII)'; // (FIX) Mencocokkan ІШ ATAU ІII
            
            $number_pattern = '(?:' . $roman . '|' . $cyrillic . '|' . $arabic . ')\b'; 
            $title_pattern = '[A-Z][A-Z\s&]+';
            $separator_pattern = '(?:\s+|\s*\n\s*)'; 

            // Regex Header Bab (Lengkap):
            // Grup 1: (BAB 1 JUDUL)
            // Grup 2: (JUDUL \n BAB 1)
            // Grup 3: (BAB 1) (saja)
            $regex_chapter_header = '/^((?:BAB|ВАВ)\s+' . $number_pattern . $separator_pattern . $title_pattern . ')|' .
                                  '^(' . $title_pattern . $separator_pattern . '(?:BAB|ВАВ)\s+' . $number_pattern . ')|' .
                                  '^((?:BAB|ВАВ)\s+' . $number_pattern . ')/im';
            
            // Regex untuk MENGHAPUS awalan "BAB X" dari judul
            $regex_strip_bab_prefix = '/^(?:BAB|ВАВ)\s+(?:' . $roman . '|' . $cyrillic . '|' . $arabic . ')\b\s*/i';

            // Pola Cek Daftar Isi (ToC) v11/v12 (AMAN):
            // Cek jika halaman berisi kata "DAFTAR ISI", "DAFTAR GAMBAR", dll.
            $regex_is_toc_page = '/(DAFTAR ISI|DAFTAR GAMBAR|DAFTAR TABEL|DAFTAR KODE SUMBER)/i';
            
            // Pola Stop
            $regex_stop_signals = '/^(DAFTAR PUSTAKA|LAMPIRAN)/i';
            // ==================

            foreach ($pages as $pageNum => $page) {
                $rawPageText = $page->getText();
                $pageText = $this->cleanPageText($rawPageText); 

                if (empty($pageText)) {
                    continue;
                }

                // Normalisasi (tetap dilakukan untuk membersihkan judul)
                $pageText = str_replace(["ВАВ ІШ", "ВАВ III", "ВАВ ІII"], "BAB III", $pageText);

                // 1. Cek Stop
                if ($recording && preg_match($regex_stop_signals, $pageText)) {
                    Log::info("Stop signal found (DAFTAR PUSTAKA/LAMPIRAN) at page {$pageNum}. Stopping recording.");
                    $recording = false;
                    if (!empty(trim($currentChapterContent))) {
                        $chapters[] = ['judul' => $currentChapterTitle, 'isi' => trim($currentChapterContent)];
                    }
                    break; 
                }

                // 2. SANITY CHECK (ToC) v11/v12
                if (preg_match($regex_is_toc_page, $pageText)) {
                    Log::info("Page {$pageNum} identified as Table of Contents (DAFTAR ISI, etc). Skipping all headers on this page.");
                    continue; // Lanjut ke halaman berikutnya
                }

                // 3. Cek Header Bab (HANYA jika bukan halaman ToC)
                if (preg_match_all($regex_chapter_header, $pageText, $matches, PREG_SET_ORDER)) {
                    
                    $textToAppend = $pageText;
                    
                    foreach ($matches as $match) {
                        $fullMatchedHeader = trim(preg_replace('/\s+/', ' ', $match[0]));

                        // 4. Ekstraksi Judul (v11/v12)
                        $newTitle = trim(preg_replace($regex_strip_bab_prefix, '', $fullMatchedHeader));
                        
                        if (empty($newTitle)) {
                            $newTitle = $fullMatchedHeader;
                        }
                        
                        $isBab1 = preg_match('/^(?:BAB|ВАВ)\s+(?:I|1)\b/i', $fullMatchedHeader);

                        // 5. Logika Merekam
                        if (!$recording) {
                            if ($isBab1) { 
                                Log::info("Found REAL BAB I ('{$newTitle}') at page {$pageNum}. Starting recording.");
                                $recording = true;
                                $currentChapterTitle = $newTitle;
                                $textToAppend = trim(preg_replace('/' . preg_quote($match[0], '/') . '/', '', $textToAppend, 1));
                            } else {
                                 Log::info("Found header ('{$newTitle}') but it's not BAB I. Ignoring until BAB I is found.");
                            }
                        } else {
                            Log::info("Found new chapter ('{$newTitle}') at page {$pageNum}. Saving previous chapter.");
                            if (!empty(trim($currentChapterContent))) {
                                $chapters[] = ['judul' => $currentChapterTitle, 'isi' => trim($currentChapterContent)];
                            }
                            $currentChapterTitle = $newTitle;
                            $textToAppend = trim(preg_replace('/' . preg_quote($match[0], '/') . '/', '', $textToAppend, 1));
                            $currentChapterContent = ""; 
                        }
                    } 

                    // 6. Tambahkan sisa teks
                    if ($recording && !empty(trim($textToAppend))) {
                        $currentChapterContent .= "\n\n" . $textToAppend;
                    }
                
                } elseif ($recording) {
                    $currentChapterContent .= "\n\n" . $pageText;
                }
            }

            // Simpan bab terakhir
            if ($recording && !empty(trim($currentChapterContent))) {
                Log::info("Saving last chapter ('{$currentChapterTitle}').");
                $chapters[] = ['judul' => $currentChapterTitle, 'isi' => trim($currentChapterContent)];
            }
            
            if (empty($chapters)) {
                Log::warning("Page-by-page loop finished but no valid chapters were recorded.", ['doc_id' => $this->documentId ?? null]);
            }

            return $chapters;

        } catch (\Exception $e) {
            Log::error("splitByBab failed: " . $e->getMessage(), ['doc_id' => $this->documentId ?? null]);
            return []; // Kembalikan array kosong jika ada error
        }
    }
}