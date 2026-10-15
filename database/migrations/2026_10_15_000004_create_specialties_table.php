<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('slug')->unique();
            $table->string('badge_en')->default('Clinical Domain');
            $table->string('badge_bn')->default('বিশেষায়িত ক্ষেত্র');
            $table->text('description_en');
            $table->text('description_bn');
            $table->text('approach_en')->nullable();
            $table->text('approach_bn')->nullable();
            $table->string('icon_class')->default('bi-heart-pulse-fill');
            $table->string('icon_color')->default('clinical-icon-blue'); // 'clinical-icon-blue', 'clinical-icon-emerald', etc.
            $table->json('tags_en')->nullable();
            $table->json('tags_bn')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};

