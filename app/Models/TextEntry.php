<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TextEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'upload_status',
        'corrected_content', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
