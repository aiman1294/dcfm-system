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
        Schema::table('case_files', function (Blueprint $table) {
            //
            $table->date('hearing_date')->nullable();
            $table->text('judge_notes')->nullable();
            $table->text('verdict')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_files', function (Blueprint $table) {
            //
            $table->dropColumn(['hearing_date', 'judge_notes', 'verdict']);
        });
    }
};
