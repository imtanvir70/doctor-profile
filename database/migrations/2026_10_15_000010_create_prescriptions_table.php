<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_no')->unique(); // e.g. RX-2026-0001
            $table->foreignId('serial_id')->nullable()->constrained('serials')->nullOnDelete();
            $table->foreignId('chamber_id')->nullable()->constrained('chambers')->nullOnDelete();
            
            // Patient details
            $table->string('patient_name');
            $table->string('patient_phone');
            $table->integer('patient_age')->nullable();
            $table->string('patient_gender')->default('Male');
            $table->string('patient_address')->nullable();
            $table->date('consultation_date');
            
            // Clinical Vitals
            $table->string('bp_systolic')->nullable();
            $table->string('bp_diastolic')->nullable();
            $table->string('pulse')->nullable();
            $table->string('weight')->nullable();
            $table->string('temperature')->nullable();
            $table->string('blood_sugar')->nullable();
            $table->string('spo2')->nullable();
            
            // Clinical Diagnosis
            $table->text('chief_complaints')->nullable();
            $table->text('clinical_history')->nullable();
            $table->text('diagnosis')->nullable();
            
            // Medicines JSON array
            // Structure: [{"name":"Tab. Metformin 500mg","dose":"1+0+1","timing":"After meal","duration":"30 days","instructions":"Take with water"}]
            $table->json('medicines');
            
            // Investigations JSON array
            // Structure: [{"name":"HbA1c","instructions":"Fasting not mandatory"},{"name":"Serum Creatinine","instructions":""}]
            $table->json('investigations')->nullable();
            
            // Advice & follow-up
            $table->text('special_advice')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->text('doctor_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};

