<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentChapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'chapter_title',
        'chapter_order',
        'original_text',
        'corrected_text',
        'status',
        'details',
    ];

    /**
     * Get the parent document.
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}