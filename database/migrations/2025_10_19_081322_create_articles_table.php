<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // タイトル
            $table->string('slug')->unique(); // URLスラッグ
            $table->longText('content'); // 本文(RichEditor)
            $table->string('category'); // カテゴリ
            $table->string('thumbnail')->nullable(); // サムネイル画像
            $table->boolean('is_published')->default(false); // 公開フラグ
            $table->date('published_at')->nullable(); // 公開日
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
