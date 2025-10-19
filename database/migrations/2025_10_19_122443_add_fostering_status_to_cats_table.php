<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. 一時テーブルにデータをバックアップ
        DB::statement('CREATE TABLE cats_backup AS SELECT * FROM cats');

        // 2. 元のテーブルを削除
        Schema::dropIfExists('cats');

        // 3. 新しい制約で再作成
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('breed')->nullable();
            $table->string('age')->nullable();
            $table->string('birthday')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_neutered')->default(false);
            $table->string('fur_type')->nullable();
            $table->string('fur_color')->nullable();
            $table->string('eye_color')->nullable();
            $table->text('personality')->nullable();
            $table->text('health_info')->nullable();
            $table->text('description')->nullable();
            $table->text('reason_for_protection')->nullable();
            $table->enum('status', ['fostering', 'available', 'reserved', 'adopted'])->default('fostering'); // ← ここにセミコロン!
            $table->date('protection_date')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });

        // 4. バックアップからデータを復元
        DB::statement("
            INSERT INTO cats (
                id, name, breed, age, birthday, gender, is_neutered,
                fur_type, fur_color, eye_color, personality, health_info,
                description, reason_for_protection, status, protection_date,
                images, created_at, updated_at
            )
            SELECT
                id, name, breed, age, birthday, gender, is_neutered,
                fur_type, fur_color, eye_color, personality, health_info,
                description, reason_for_protection,
                CASE
                    WHEN status = 'available' THEN 'available'
                    WHEN status = 'reserved' THEN 'reserved'
                    WHEN status = 'adopted' THEN 'adopted'
                    ELSE 'fostering'
                END as status,
                protection_date, images, created_at, updated_at
            FROM cats_backup
        ");

        // 5. バックアップテーブルを削除
        DB::statement('DROP TABLE cats_backup');
    }

    public function down(): void
    {
        // 元に戻す処理
    }
};
