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
        'disk', 
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

    public function chapters()
    {
        return $this->hasMany(DocumentChapter::class)->orderBy('chapter_order');
    }
}