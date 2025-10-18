<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'address',
        'access_info',
        'status',
        'notes',
        'is_published',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_published' => 'boolean',
    ];

    public function cats()
    {
        return $this->belongsToMany(Cat::class);
    }
}
