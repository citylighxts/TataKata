<?php

namespace App\Http\Controllers;

use App\Models\DocumentChapter;
use App\Jobs\CorrectChapterJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChapterController extends Controller
{
    /**
     * Mulai proses koreksi untuk satu bab.
     */
    public function startCorrection(DocumentChapter $chapter)
    {
        // Otorisasi: Pastikan chapter ini milik user yang sedang login
        if ($chapter->document->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        
        // Hanya proses jika statusnya Pending atau Failed
        if ($chapter->status === 'Pending' || $chapter->status === 'Failed') {
            Log::info("Dispatching CorrectChapterJob for Chapter ID: {$chapter->id}");
            $chapter->update(['status' => 'Queued', 'details' => 'Antrian...']);
            CorrectChapterJob::dispatch($chapter);
        }

        return response()->json([
            'status' => 'Queued',
            'message' => 'Proses koreksi bab telah dimulai.'
        ]);
    }

    /**
     * Cek status koreksi satu bab (untuk polling AJAX).
     */
    public function checkStatus(DocumentChapter $chapter)
    {
        // Otorisasi
        if ($chapter->document->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        
        $chapter->refresh();

        return response()->json([
            'id' => $chapter->id,
            'status' => $chapter->status,
            'details' => $chapter->details,
            // Hanya kirim teks koreksi jika sudah selesai untuk efisiensi payload
            'corrected_text' => $chapter->status === 'Completed' ? $chapter->corrected_text : null,
        ]);
    }
}