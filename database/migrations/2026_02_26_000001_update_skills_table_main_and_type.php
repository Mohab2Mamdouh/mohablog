<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert existing 'main' string values to boolean-compatible values
        DB::table('skills')->where('main', 'primary')->update(['main' => '1']);
        DB::table('skills')->where('main', '!=', '1')->update(['main' => '0']);

        Schema::table('skills', function (Blueprint $table) {
            $table->boolean('main')->default(false)->change();
            $table->string('type')->change();
        });

        // Fix typo: 'Fontend' -> 'Frontend' in existing data
        DB::table('skills')->where('type', 'Fontend')->update(['type' => 'Frontend']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('main')->change();
            $table->text('type')->change();
        });

        DB::table('skills')->where('type', 'Frontend')->update(['type' => 'Fontend']);
    }
};

