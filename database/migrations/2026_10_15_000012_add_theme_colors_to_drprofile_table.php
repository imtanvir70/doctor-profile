<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drprofile', function (Blueprint $table) {
            $table->string('primary_color', 20)->default('#0F3B66')->after('linkedin_url');
            $table->string('primary_hover', 20)->default('#0a2744')->after('primary_color');
            $table->string('accent_color', 20)->default('#059669')->after('primary_hover');
            $table->string('accent_hover', 20)->default('#047857')->after('accent_color');
            $table->string('soft_accent', 20)->default('#E0F2FE')->after('accent_hover');
            $table->string('site_title_en')->nullable()->after('soft_accent');
            $table->string('site_title_bn')->nullable()->after('site_title_en');
        });
    }

    public function down(): void
    {
        Schema::table('drprofile', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color',
                'primary_hover',
                'accent_color',
                'accent_hover',
                'soft_accent',
                'site_title_en',
                'site_title_bn',
            ]);
        });
    }
};

