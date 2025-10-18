<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_posts', function (Blueprint $table) {
            $table->id();

            // 投稿情報
            $table->string('title')->comment('タイトル');
            $table->text('content')->comment('本文');
            $table->date('post_date')->comment('投稿日');

            // カテゴリー
            $table->enum('category', ['adoption', 'rescue', 'event', 'other'])
                ->default('other')
                ->comment('カテゴリ: adoption=譲渡報告, rescue=保護報告, event=イベント報告, other=その他');

            // 画像
            $table->json('images')->nullable()->comment('記事の画像パス(JSON配列)');

            // 公開設定
            $table->boolean('is_published')->default(true)->comment('公開フラグ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_posts');
    }
};
