<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drprofile', function (Blueprint $table) {
            $table->string('bmdc_reg')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('drprofile', function (Blueprint $table) {
            $table->string('bmdc_reg')->nullable(false)->change();
        });
    }
};

