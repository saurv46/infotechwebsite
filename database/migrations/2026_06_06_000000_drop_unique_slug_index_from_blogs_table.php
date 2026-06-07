<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop the plain unique index on blog_slug.
     *
     * A plain unique index keeps a soft-deleted blog's slug reserved, which
     * blocks reuse. Uniqueness is instead enforced in the controller against
     * ACTIVE blogs only (Rule::unique(...)->whereNull('deleted_at')), so a
     * deleted blog's slug becomes available again.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropUnique('blogs_blog_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->unique('blog_slug', 'blogs_blog_slug_unique');
        });
    }
};
