<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drprofile', function (Blueprint $table) {
            $table->id();
            // Basic Doctor Identity
            $table->string('name_en')->default('Dr. Abu Hanif Rakib');
            $table->string('name_bn')->default('ডাঃ মোঃ আবু হানিফ রাকিব');
            $table->string('designation_en')->default('Senior Consultant Medicine Specialist');
            $table->string('designation_bn')->default('সিনিয়র কনসালট্যান্ট ও মেডিসিন বিশেষজ্ঞ');
            $table->string('degrees_en')->default('MBBS, BCS (Health), FCPS (Medicine)');
            $table->string('degrees_bn')->default('এমবিবিএস, বিসিএস (স্বাস্থ্য), এফসিপিএস (মেডিসিন)');
            $table->string('bmdc_reg')->nullable()->default('84321');
            $table->string('experience_years')->default('12+');
            $table->string('patients_count')->default('28,000+');
            $table->string('satisfaction_rate')->default('98.7%');
            $table->string('avatar')->nullable();
            
            // Hero section texts
            $table->string('hero_badge_en')->default('BMDC Reg No: 84321');
            $table->string('hero_badge_bn')->default('বিএমডিসি রেজি নং: ৮৪৩২১');
            $table->text('hero_bio_en')->nullable();
            $table->text('hero_bio_bn')->nullable();
            
            // About section
            $table->string('about_headline_en')->nullable();
            $table->string('about_headline_bn')->nullable();
            $table->text('about_p1_en')->nullable();
            $table->text('about_p1_bn')->nullable();
            $table->text('about_p2_en')->nullable();
            $table->text('about_p2_bn')->nullable();
            $table->string('academic_post1_en')->nullable();
            $table->string('academic_post1_bn')->nullable();
            $table->string('academic_desc1_en')->nullable();
            $table->string('academic_desc1_bn')->nullable();
            
            // Emergency & Hotlines
            $table->string('hotline_phone')->default('+8801700000000');
            $table->string('hotline_whatsapp')->default('8801700000000');
            $table->string('email')->default('consultation@drabuhanifrakib.com');
            $table->string('consultation_fee')->default('BDT 1,200');
            $table->text('emergency_notice_en')->nullable();
            $table->text('emergency_notice_bn')->nullable();
            
            // Social Links
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drprofile');
    }
};

