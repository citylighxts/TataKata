<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'file_name',
        'file_location',
        'disk', // Pastikan 'disk' ada di fillable
        'upload_status',
        'details',
        'original_text',
        'corrected_text',
        'progress_log'
    ];

    protected $casts = [
        'progress_log' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * TAMBAHKAN FUNGSI INI
     * Get all of the chapters for the document.
     */
    public function chapters()
    {
        return $this->hasMany(DocumentChapter::class)->orderBy('chapter_order');
    }
}