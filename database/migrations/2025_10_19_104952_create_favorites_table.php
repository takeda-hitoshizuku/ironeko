<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->string('session_id'); // セッションIDで識別
            $table->timestamps();

            $table->foreign('cat_id')->references('id')->on('cats')->onDelete('cascade');
            $table->unique(['cat_id', 'session_id']); // 重複防止
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
