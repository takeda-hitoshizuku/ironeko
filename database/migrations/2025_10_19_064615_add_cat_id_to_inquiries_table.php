<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id')->nullable()->after('id');
            $table->foreign('cat_id')->references('id')->on('cats')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['cat_id']);
            $table->dropColumn('cat_id');
        });
    }
};
