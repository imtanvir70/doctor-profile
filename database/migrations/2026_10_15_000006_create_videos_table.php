<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('youtube_id')->default('ScMzIvxBSi4');
            $table->string('category')->default('diabetes'); // 'diabetes', 'hypertension', 'antibiotic', 'fever', 'respiratory'
            $table->string('duration')->default('8:45');
            $table->text('description_en');
            $table->text('description_bn');
            $table->string('thumbnail')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};

