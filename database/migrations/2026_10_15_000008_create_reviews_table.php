<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_initials')->default('AR');
            $table->string('color_class')->default('clinical-icon-blue');
            $table->string('location_tag_en')->default('Diabetes Care • Dhanmondi');
            $table->string('location_tag_bn')->default('ডায়াবেটিস রোগী • ধানমন্ডি');
            $table->integer('rating')->default(5);
            $table->text('review_text_en');
            $table->text('review_text_bn');
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

