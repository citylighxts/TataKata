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
            Log::info("Total pages found: " . count($pages), ['document_id' => $document->id]);

            $chapters_data = $this->splitByBab($pages); 
            
            if (empty($chapters_data)) {
                 throw new \Exception('Gagal memecah dokumen. Tidak ada bab valid (BAB I, BAB II, dst.) yang ditemukan.');
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
                    throw new \Exception('Tidak ada bab yang valid ditemukan setelah pemrosesan.');
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

    // =================================================================
    // == FUNGSI SPLITBYBAB BARU (METODE PAGE-BY-PAGE v6) ==
    // =================================================================

    /**
     * Membersihkan teks per halaman (Versi AMAN)
     */
    private function cleanPageText(string $text): string
    {
        // Gabung hyphen
        $text = preg_replace('/(\w)-\n(\w)/', '$1$2', $text); 
        // Normalisasi newline
        $text = preg_replace('/\n{3,}/', "\n\n", $text); 
        
        return trim($text);
    }

    /**
     * Memecah dokumen berdasarkan array Halaman ($pages)
     */
    private function splitByBab(array $pages): array
    {
        $chapters = [];
        $currentChapterContent = "";
        $currentChapterTitle = "";
        $recording = false;

        // ==================
        // PERBAIKAN REGEX v6
        // ==================
        // Pola nomor Bab: Mencari nomor Romawi (I-X) atau Angka (1-10) atau Cyrillic (ІШ)
        // Ditambahkan \b (word boundary) agar "I" tidak cocok dengan "III"
        $roman = 'X|IX|IV|V?I{0,3}'; // I, II, III, IV, V, VI, VII, VIII, IX, X
        $arabic = '\d+'; // 1, 2, 3...
        $cyrillic = 'ІШ'; // Khusus untuk BAB III Anda
        
        // Pola Header Bab (Lengkap):
        $regex_chapter_header = '/^((?:BAB|ВАВ)\s+(?:' . $roman . '|' . $cyrillic . '|' . $arabic . ')\b\s*\n\s*[A-Z][A-Z\s&]+)/im';
        
        // Pola Cek DAFTAR ISI:
        // Cek jika header bab diikuti oleh spasi/titik dan angka (nomor halaman ToC)
        $regex_is_toc_line = '/^((?:BAB|ВАВ)\s+(?:' . $roman . '|' . $cyrillic . '|' . $arabic . ')\b\s*\n\s*[A-Z][A-Z\s&]+)[\s.]*\d+/im';
        
        // Pola Stop
        $regex_stop_signals = '/^(DAFTAR PUSTAKA|LAMPIRAN)/i';

        foreach ($pages as $pageNum => $page) {
            // Normalisasi karakter aneh "ВАВ ІШ" -> "BAB III"
            // (Tetap dilakukan untuk membersihkan judul, meskipun regex sudah menangani)
            $rawPageText = str_replace(["ВАВ ІШ", "ВАВ III"], "BAB III", $page->getText());
            $pageText = $this->cleanPageText($rawPageText);

            if (empty($pageText)) {
                continue;
            }

            // 1. Cek apakah kita harus BERHENTI merekam (Daftar Pustaka, dll)
            if ($recording && preg_match($regex_stop_signals, $pageText)) {
                Log::info("Stop signal found (DAFTAR PUSTAKA) at page {$pageNum}. Stopping recording.");
                $recording = false;
                if (!empty(trim($currentChapterContent))) {
                    $chapters[] = ['judul' => $currentChapterTitle, 'isi' => trim($currentChapterContent)];
                }
                break; // Keluar dari loop utama
            }

            // 2. Cek apakah halaman ini mengandung Header Bab
            if (preg_match_all($regex_chapter_header, $pageText, $matches, PREG_SET_ORDER)) {
                
                $textToAppend = $pageText;
                
                // Cari semua header ToC di halaman ini SEKALI SAJA
                $toc_headers_on_this_page = [];
                if (preg_match_all($regex_is_toc_line, $pageText, $toc_matches)) {
                    foreach ($toc_matches[1] as $toc_header_raw) {
                         $toc_headers_on_this_page[] = trim(preg_replace('/\s+/', ' ', $toc_header_raw));
                    }
                }

                foreach ($matches as $match) {
                    $newTitle = trim(preg_replace('/\s+/', ' ', $match[1]));

                    // 3. SANITY CHECK: Apakah header ini ada di daftar ToC yang kita temukan?
                    if (in_array($newTitle, $toc_headers_on_this_page)) {
                        Log::info("Found header ('{$newTitle}') at page {$pageNum}, but it's a Table of Contents entry. Ignoring.");
                        // Hapus header ToC ini dari teks agar tidak ter-append jika kita sedang merekam
                        $textToAppend = str_replace($match[0], '', $textToAppend); 
                        continue; // Lanjut ke match berikutnya di halaman yang sama
                    }

                    // 4. JIKA INI BUKAN DAFTAR ISI: Ini adalah header bab yang asli
                    
                    // 5. Jika kita BELUM merekam (ini BAB I)
                    if (!$recording) {
                        Log::info("Found REAL BAB I ('{$newTitle}') at page {$pageNum}. Starting recording.");
                        $recording = true;
                        $currentChapterTitle = $newTitle;
                        // Hapus judul dari isi teks
                        $textToAppend = trim(preg_replace('/' . preg_quote($match[0], '/') . '/', '', $textToAppend, 1));
                    
                    // 6. Jika kita SUDAH merekam (ini BAB II, III, dst.)
                    } else {
                        Log::info("Found new chapter ('{$newTitle}') at page {$pageNum}. Saving previous chapter.");
                        // Simpan bab sebelumnya
                        if (!empty(trim($currentChapterContent))) {
                            $chapters[] = ['judul' => $currentChapterTitle, 'isi' => trim($currentChapterContent)];
                        }
                        // Mulai bab baru
                        $currentChapterTitle = $newTitle;
                        $textToAppend = trim(preg_replace('/' . preg_quote($match[0], '/') . '/', '', $textToAppend, 1));
                        $currentChapterContent = ""; // Reset konten
                    }
                } // Selesai loop $matches

                // 7. Tambahkan sisa teks di halaman ini (jika ada) ke bab saat ini
                if ($recording && !empty(trim($textToAppend))) {
                    $currentChapterContent .= "\n\n" . $textToAppend;
                }
            
            // 8. Jika ini BUKAN halaman bab baru, TAPI kita sedang merekam
            } elseif ($recording) {
                // Tambahkan teks halaman ini ke bab yang sedang berjalan
                $currentChapterContent .= "\n\n" . $pageText;
            }
            
            // 9. Jika kita belum merekam (masih di Abstrak, dll), abaikan saja.
        }

        // Simpan bab terakhir yang tersisa setelah loop selesai
        if ($recording && !empty(trim($currentChapterContent))) {
            Log::info("Saving last chapter ('{$currentChapterTitle}').");
            $chapters[] = ['judul' => $currentChapterTitle, 'isi' => trim($currentChapterContent)];
        }
        
        if (empty($chapters)) {
             Log::warning("Page-by-page loop finished but no valid chapters were recorded.", ['doc_id' => $this->documentId ?? null]);
        }

        return $chapters;
    }
}