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
        Schema::create('cats', function (Blueprint $table) {
            $table->id();

            // 基本情報
            $table->string('name')->comment('猫の名前');
            $table->string('age')->nullable()->comment('年齢(例: 2歳3ヶ月、生後6ヶ月など)');
            $table->string('birthday')->nullable()->comment('誕生日(不明な場合は推定や季節を記入)');
            $table->enum('gender', ['male', 'female'])->comment('性別: male=オス, female=メス');
            $table->boolean('is_neutered')->default(false)->comment('避妊・去勢手術済みフラグ');

            // 外見
            $table->string('fur_type')->nullable()->comment('毛質(例: 短毛、長毛)');
            $table->string('fur_color')->nullable()->comment('毛色');
            $table->string('eye_color')->nullable()->comment('目の色');

            // 性格・健康情報
            $table->text('personality')->nullable()->comment('性格の説明');
            $table->text('health_info')->nullable()->comment('健康状態・ワクチン接種状況など');
            $table->text('description')->nullable()->comment('その他詳細説明');
            $table->text('reason_for_protection')->nullable()->comment('保護・譲渡理由');

            // ステータス管理
            $table->enum('status', ['available', 'reserved', 'adopted'])
                ->default('available')
                ->comment('譲渡状況: available=募集中, reserved=予約済み, adopted=譲渡済み');
            $table->date('protection_date')->nullable()->comment('保護した日');

            // 画像
            $table->json('images')->nullable()->comment('猫の画像パス(JSON配列)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats');
    }
};
