<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title_en')->nullable()->change();
            $table->string('title_bn')->nullable()->change();
            $table->string('slug')->nullable()->change();
            $table->text('excerpt_en')->nullable()->change();
            $table->text('excerpt_bn')->nullable()->change();
            $table->longText('content_en')->nullable()->change();
            $table->longText('content_bn')->nullable()->change();
            $table->timestamp('published_at')->nullable()->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
};
