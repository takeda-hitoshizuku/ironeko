<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'cat_id',
        'session_id',
    ];

    // リレーション
    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }

    // セッションIDごとのお気に入り数を取得
    public static function getCountByCat($catId)
    {
        return self::where('cat_id', $catId)->count();
    }
}
