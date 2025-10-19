<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'thumbnail',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'date',
    ];

    // スラッグを自動生成
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // カテゴリの選択肢
    public static function getCategoryOptions(): array
    {
        return [
            'preparation' => 'お迎え準備',
            'health' => '健康管理',
            'behavior' => 'しつけ・行動',
            'basics' => '猫の基礎知識',
            'goods' => 'おすすめグッズ',
            'other' => 'その他',
        ];
    }

    // カテゴリ名を取得
    public function getCategoryNameAttribute(): string
    {
        return self::getCategoryOptions()[$this->category] ?? 'その他';
    }
}
