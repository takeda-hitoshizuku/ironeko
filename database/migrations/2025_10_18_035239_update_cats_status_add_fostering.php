<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLiteの場合はテーブルを作り直す必要があるため、シンプルな方法で
        DB::statement("UPDATE cats SET status = 'available' WHERE status NOT IN ('available', 'reserved', 'adopted', 'fostering')");
    }

    public function down(): void
    {
        //
    }
};
