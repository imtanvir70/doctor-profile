<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('slug')->unique();
            $table->string('category')->default('lifestyle'); // 'diabetes', 'heart', 'lifestyle', 'infection', 'endocrine'
            $table->string('badge_en')->default('Health Column');
            $table->string('badge_bn')->default('স্বাস্থ্য কলাম');
            $table->text('excerpt_en');
            $table->text('excerpt_bn');
            $table->longText('content_en');
            $table->longText('content_bn');
            $table->string('featured_image')->nullable();
            $table->string('read_time')->default('5 min read');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

