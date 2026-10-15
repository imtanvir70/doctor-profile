<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('international_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('organization')->comment('e.g. WHO, Oxford, CDC, Lancet, etc.');
            $table->string('country_or_location')->nullable()->comment('e.g. Geneva, Switzerland or Multi-center');
            $table->string('role_en')->default('Principal Investigator');
            $table->string('role_bn')->default('প্রধান গবেষক');
            $table->string('duration')->nullable()->comment('e.g. 2022 - 2024');
            $table->string('category')->default('Clinical Trial')->comment('Clinical Trial, Epidemiology, Public Health, Research');
            $table->string('badge_text')->nullable()->comment('e.g. WHO Sponsored, Published in BMJ');
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->string('project_url')->nullable();
            $table->string('icon')->default('bi-globe-americas');
            $table->integer('display_order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('international_projects');
    }
};

