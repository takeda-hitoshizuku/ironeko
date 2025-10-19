<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'category',
        'status',
        'admin_notes',
    ];

    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }
}
