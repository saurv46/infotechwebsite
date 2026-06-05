<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill any existing rows so the NOT NULL change can apply.
        DB::table('contacts')->whereNull('email')->update(['email' => '']);

        Schema::table('contacts', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }
};
