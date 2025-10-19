<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'breed',
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

    // リレーション: お気に入り
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // お気に入り数を取得
    // お気に入り数を取得
    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }
}
