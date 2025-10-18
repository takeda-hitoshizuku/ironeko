<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'birthday',
        'gender',
        'is_neutered',
        'fur_type',
        'fur_color',
        'eye_color',
        'personality',
        'health_info',
        'description',
        'reason_for_protection',
        'status',
        'protection_date',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'is_neutered' => 'boolean',
        'protection_date' => 'date',
    ];

    public function adoptionEvents()
    {
        return $this->belongsToMany(AdoptionEvent::class);
    }
}
