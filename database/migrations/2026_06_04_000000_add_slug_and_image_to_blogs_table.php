<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('blog_slug')->unique()->after('blog_title');
            // Stores the web-accessible path, e.g. "uploads/blogs/xyz.jpg".
            // Nullable at the DB level (existing rows have no image); the
            // upload itself is enforced as required during validation.
            $table->string('blog_image')->nullable()->after('blog_description');
            $table->boolean('is_featured')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['blog_slug', 'blog_image', 'is_featured']);
        });
    }
};
