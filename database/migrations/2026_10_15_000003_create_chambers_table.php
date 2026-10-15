<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chambers', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('slug')->unique(); // 'dhanmondi', 'uttara'
            $table->string('badge_en')->default('Dhanmondi Chamber');
            $table->string('badge_bn')->default('ধানমন্ডি চেম্বার');
            $table->text('address_en');
            $table->text('address_bn');
            $table->string('visiting_days_en');
            $table->string('visiting_days_bn');
            $table->string('visiting_hours_en');
            $table->string('visiting_hours_bn');
            $table->string('weekly_off_en')->default('Thursday & Friday');
            $table->string('weekly_off_bn')->default('বৃহস্পতিবার ও শুক্রবার');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('fee')->default('BDT 1,200');
            $table->text('map_url')->nullable();
            $table->text('facilities_en')->nullable();
            $table->text('facilities_bn')->nullable();
            $table->string('note_en')->nullable();
            $table->string('note_bn')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chambers');
    }
};

