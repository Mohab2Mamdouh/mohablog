<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->date('endDate')->nullable()->change();
            $table->text('appURL')->nullable()->change();
            $table->text('description')->nullable()->after('caption');
            $table->string('link')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->date('endDate')->nullable(false)->change();
            $table->text('appURL')->nullable(false)->change();
            $table->dropColumn(['description', 'link']);
        });
    }
};

