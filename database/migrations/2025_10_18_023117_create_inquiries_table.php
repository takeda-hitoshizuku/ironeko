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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();

            // お問い合わせ者情報
            $table->string('name')->comment('お名前');
            $table->string('email')->comment('メールアドレス');
            $table->string('phone')->nullable()->comment('電話番号');

            // お問い合わせ内容
            $table->string('subject')->nullable()->comment('件名');
            $table->text('message')->comment('お問い合わせ内容');

            // カテゴリー
            $table->enum('category', ['adoption', 'volunteer', 'donation', 'other'])
                ->default('other')
                ->comment('カテゴリ: adoption=譲渡について, volunteer=ボランティア, donation=寄付, other=その他');

            // ステータス管理
            $table->enum('status', ['new', 'in_progress', 'resolved'])
                ->default('new')
                ->comment('対応状況: new=未対応, in_progress=対応中, resolved=解決済み');

            // 管理用メモ
            $table->text('admin_notes')->nullable()->comment('管理者用メモ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
