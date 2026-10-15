<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number'); // e.g. SL-20261015-001
            $table->foreignId('chamber_id')->nullable()->constrained('chambers')->nullOnDelete();
            $table->string('chamber_name');
            $table->string('patient_name');
            $table->string('patient_phone');
            $table->date('preferred_date');
            $table->integer('patient_age')->nullable();
            $table->enum('patient_gender', ['male', 'female', 'other'])->default('male');
            $table->enum('visit_type', ['new', 'followup', 'report'])->default('new');
            $table->text('symptoms_summary')->nullable();
            $table->json('medical_reports')->nullable(); // uploaded files paths
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('sms_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serials');
    }
};

