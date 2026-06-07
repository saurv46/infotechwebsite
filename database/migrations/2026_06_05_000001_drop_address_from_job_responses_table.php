<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('job_responses', 'address')) {
            Schema::table('job_responses', function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('job_responses', 'address')) {
            Schema::table('job_responses', function (Blueprint $table) {
                $table->string('address')->after('phone_number');
            });
        }
    }
};
