<?php

namespace App\Http\Controllers;

use App\Models\DocumentChapter;
use App\Jobs\CorrectChapterJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChapterController extends Controller
{
    public function startCorrection(DocumentChapter $chapter)
    {
        if ($chapter->document->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        
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

    public function checkStatus(DocumentChapter $chapter)
    {
        if ($chapter->document->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        
        $chapter->refresh();

        return response()->json([
            'id' => $chapter->id,
            'status' => $chapter->status,
            'details' => $chapter->details,
            'corrected_text' => $chapter->status === 'Completed' ? $chapter->corrected_text : null,
        ]);
    }
}