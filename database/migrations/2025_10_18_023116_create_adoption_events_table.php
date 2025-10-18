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
        Schema::create('adoption_events', function (Blueprint $table) {
            $table->id();

            // イベント基本情報
            $table->string('title')->comment('譲渡会のタイトル');
            $table->text('description')->nullable()->comment('イベントの詳細説明');

            // 日時・場所
            $table->date('event_date')->comment('開催日');
            $table->time('start_time')->comment('開始時間');
            $table->time('end_time')->comment('終了時間');
            $table->string('venue')->comment('会場名');
            $table->text('address')->nullable()->comment('住所');
            $table->text('access_info')->nullable()->comment('アクセス方法');

            // ステータス
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])
                ->default('scheduled')
                ->comment('ステータス: scheduled=予定, completed=終了, cancelled=中止');

            // その他
            $table->text('notes')->nullable()->comment('注意事項・持ち物など');
            $table->boolean('is_published')->default(true)->comment('公開フラグ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_events');
    }
};
