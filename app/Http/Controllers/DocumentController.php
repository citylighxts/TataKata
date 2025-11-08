<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\History;
use App\Jobs\ProcessDocumentCorrection; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    // ... (Fungsi uploadForm dan upload tetap SAMA) ...
    public function uploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string',
            'file' => 'required|mimes:pdf|max:10240',
        ]);
        try {
            $file = $request->file('file');
            $document_name = $request->input('document_name');

            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.pdf';
            $usedDisk = config('filesystems.default') ?: 'public';
            $path = $file->storeAs('documents', $filename, $usedDisk);

            \Log::info('Upload: stored file', [
                'file_path' => $path,
                'disk' => $usedDisk,
                'db_driver' => config('database.default'),
                'user_id' => Auth::id(),
            ]);

            // Hapus dokumen lama dengan nama yang sama (jika ada)
            // Document::where('user_id', Auth::id())->where('file_name', $document_name)->delete();

            $document = Document::create([
                'user_id' => Auth::id(),
                'file_name' => $document_name,
                'file_location' => $path,
                'disk' => $usedDisk,
                'upload_status' => 'Processing', 
            ]);

            \Log::info('DEBUG UPLOAD: Path Absolut', ['resolved_path' => \Storage::disk($usedDisk)->path($path)]);

            \Log::info('Upload: created Document record', [
                'document_id' => $document->id,
                'file_location' => $document->file_location,
            ]);

            History::create([
                'user_id' => Auth::id(),
                'document_id' => $document->id,
                'activity_type' => 'upload',
                'details' => 'Dokumen diunggah oleh user',
            ]);

            ProcessDocumentCorrection::dispatch($document);

            return redirect()->route('correction.status', $document->id) 
                             ->with('success', 'Dokumen berhasil diunggah dan sedang diproses...');
        } catch (\Throwable $e) {
            \Log::error('Upload failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen. Silakan coba lagi.');
        }
    }

    public function checkStatus($id)
    {
        try {
            \Log::info("🔵 Polling received for Document ID {$id}"); 

            $document = Document::find($id);
            if (! $document) {
                return response()->json([
                    'status' => 'Deleted',
                    'done' => false, // Polling harus berhenti, tapi ini bukan 'done' (sukses)
                    'details' => 'Dokumen telah dihapus oleh pengguna.',
                    'progress' => [],
                    'redirect_url' => null
                ]);
            }

            if ($document->user_id !== Auth::id()) {
                return response()->json(['status' => 'Unauthorized'], 403);
            }

            $document->refresh();
            $status = trim($document->upload_status ?? '');
            
            // ==========================================================
            // PERUBAHAN STEP 2: LOGIKA 'DONE' YANG BARU
            // ==========================================================
            
            // 'done' HANYA berarti "polling selesai DAN berhasil (siap redirect)"
            $isDoneAndReady = ($status === 'Ready');

            \Log::info("🟢 Document ID {$id} status: '{$status}'. DoneAndReady: {$isDoneAndReady}");
            
            // Frontend JS akan memeriksa 'status' string untuk 'Failed', 'Deleted', atau 'No_Chapters'
            // dan akan memeriksa 'done: true' HANYA untuk redirect
            
            return response()->json([
                'status' => $document->upload_status,
                'done' => $isDoneAndReady, // 'done' HANYA true jika status 'Ready'
                'details' => $document->details,
                'progress' => array_slice($document->progress_log ?? [], -20),
                'redirect_url' => $isDoneAndReady ? route('correction.show', $document->id) : null
            ]);
            // ==========================================================

        } catch (\Throwable $e) {
            \Log::error("❌ checkStatus ERROR: " . $e->getMessage(), [
                'document_id' => $id
            ]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    // ... (Fungsi showStatus tetap SAMA) ...
    public function showStatus($id)
    {
        $document = Document::findOrFail($id); 
        
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        return view('correction_status', compact('document'));
    }

    // == FUNGSI showCorrection DIUBAH ==
    public function showCorrection($id)
    {
        // Muat dokumen BERSAMA relasi chapters
        $document = Document::with('chapters')->findOrFail($id);
        $document->refresh();

        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $statusLower = strtolower(trim($document->upload_status ?? ''));
        
        // Hanya izinkan akses jika statusnya 'Ready' (siap dikoreksi per-bab)
        if ($statusLower !== 'ready') {
            \Log::warning("⚠️ Clash Detected: User tried accessing correction page for ID {$id} but status is '{$document->upload_status}'");
            // Kirim kembali ke halaman status jika belum 'Ready'
            return view('correction_status', compact('document'));
        }

        // Kirim $document (yang berisi $document->chapters) ke view
        return view('correction', compact('document'));
    }

    // == FUNGSI download DIUBAH ==
    public function download($id)
    {
        // Muat dokumen BERSAMA relasi chapters
        $document = Document::with('chapters')->findOrFail($id);
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke koreksi ini.');
        }

        if ($document->chapters->isEmpty()) {
            return back()->with('error', 'Dokumen ini belum dipecah menjadi bab.');
        }

        $separator = "\n\n" . str_repeat('=', 60) . "\n\n";
        $full_original_text = "";
        $full_corrected_text = "";

        foreach ($document->chapters as $chapter) {
            $full_original_text .= $chapter->chapter_title . $separator . $chapter->original_text . $separator;
            
            // Jika chapter sudah 'Completed', gunakan teks koreksi.
            // Jika tidak, gunakan teks asli sebagai fallback.
            if ($chapter->status === 'Completed' && !empty($chapter->corrected_text)) {
                $full_corrected_text .= $chapter->chapter_title . $separator . $chapter->corrected_text . $separator;
            } else {
                $full_corrected_text .= $chapter->chapter_title . $separator . $chapter->original_text . $separator;
            }
        }

        // Render Blade HTML (versi khusus untuk PDF)
        $html = view('pdf.correction', [
            'title'          => $document->file_name,
            'corrected_text' => trim($full_corrected_text),
            'original_text'  => trim($full_original_text),
        ])->render();

        // Buat PDF dari HTML Blade
        $pdf = Pdf::loadHTML($html)->setPaper('a4');

        $filename = 'koreksi-'.Str::slug($document->file_name).'-'.now()->format('Ymd-His').'.pdf';

        return $pdf->download($filename);
    }


    // ... (Fungsi viewOriginal tetap SAMA) ...
    public function viewOriginal($id)
    {
        $document = Document::findOrFail($id);
        $hasValidSignature = request()->hasValidSignature();
        $isOwner = Auth::check() && $document->user_id === Auth::id();
        
        if (! $hasValidSignature && ! $isOwner) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        $path = $document->file_location;
        if (empty($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $diskName = $document->disk ?: config('filesystems.default') ?: 'public';
        $disk = \Storage::disk($diskName);
        
        try {
            if (method_exists($disk, 'path')) {
                $localPath = $disk->path($path);
                if (file_exists($localPath)) {
                    return response()->file($localPath, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline']);
                }
            }
            if (method_exists($disk, 'temporaryUrl')) {
                return redirect()->away($disk->temporaryUrl($path, now()->addMinutes(15)));
            }
            return response()->stream(function () use ($disk, $path) {
                fpassthru($disk->readStream($path));
            }, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline']);
        } catch (\Exception $e) {
            \Log::error('Error serving original file', ['document_id' => $document->id, 'error' => $e->getMessage()]);
            abort(500, 'Terjadi kesalahan saat mengakses file.');
        }
    }
}