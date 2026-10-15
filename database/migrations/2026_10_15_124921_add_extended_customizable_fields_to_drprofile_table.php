<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drprofile', function (Blueprint $table) {
            // Stat labels
            $table->string('experience_stat_label_en')->nullable()->after('experience_years');
            $table->string('experience_stat_label_bn')->nullable()->after('experience_stat_label_en');
            $table->string('patients_stat_label_en')->nullable()->after('patients_count');
            $table->string('patients_stat_label_bn')->nullable()->after('patients_stat_label_en');
            $table->string('satisfaction_stat_label_en')->nullable()->after('satisfaction_rate');
            $table->string('satisfaction_stat_label_bn')->nullable()->after('satisfaction_stat_label_en');

            // Clinical Philosophy & Ethics (About page & highlights)
            $table->string('philosophy_title1_en')->nullable();
            $table->string('philosophy_title1_bn')->nullable();
            $table->text('philosophy_desc1_en')->nullable();
            $table->text('philosophy_desc1_bn')->nullable();

            $table->string('philosophy_title2_en')->nullable();
            $table->string('philosophy_title2_bn')->nullable();
            $table->text('philosophy_desc2_en')->nullable();
            $table->text('philosophy_desc2_bn')->nullable();

            $table->string('philosophy_title3_en')->nullable();
            $table->string('philosophy_title3_bn')->nullable();
            $table->text('philosophy_desc3_en')->nullable();
            $table->text('philosophy_desc3_bn')->nullable();

            // Expertise page banner texts
            $table->string('expertise_banner_title_en')->nullable();
            $table->string('expertise_banner_title_bn')->nullable();
            $table->text('expertise_banner_desc_en')->nullable();
            $table->text('expertise_banner_desc_bn')->nullable();

            // Footer copyright custom text
            $table->string('footer_copyright_en')->nullable();
            $table->string('footer_copyright_bn')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('drprofile', function (Blueprint $table) {
            $table->dropColumn([
                'experience_stat_label_en',
                'experience_stat_label_bn',
                'patients_stat_label_en',
                'patients_stat_label_bn',
                'satisfaction_stat_label_en',
                'satisfaction_stat_label_bn',
                'philosophy_title1_en',
                'philosophy_title1_bn',
                'philosophy_desc1_en',
                'philosophy_desc1_bn',
                'philosophy_title2_en',
                'philosophy_title2_bn',
                'philosophy_desc2_en',
                'philosophy_desc2_bn',
                'philosophy_title3_en',
                'philosophy_title3_bn',
                'philosophy_desc3_en',
                'philosophy_desc3_bn',
                'expertise_banner_title_en',
                'expertise_banner_title_bn',
                'expertise_banner_desc_en',
                'expertise_banner_desc_bn',
                'footer_copyright_en',
                'footer_copyright_bn',
            ]);
        });
    }
};
