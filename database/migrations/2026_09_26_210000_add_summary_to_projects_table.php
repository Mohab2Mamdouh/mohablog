<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The short, CV-length version of a project. `description` stays the full
     * case study for the site; the PDF prints this instead.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('caption');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('summary');
        });
    }
};
