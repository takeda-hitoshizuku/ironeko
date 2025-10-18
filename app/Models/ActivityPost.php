<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'post_date',
        'category',
        'images',
        'is_published',
    ];

    protected $casts = [
        'images' => 'array',
        'post_date' => 'date',
        'is_published' => 'boolean',
    ];
}
