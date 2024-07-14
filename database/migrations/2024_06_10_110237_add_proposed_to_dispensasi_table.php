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
        Schema::table('dispensasi', function (Blueprint $table) {
            $table->enum('status_persetujuan', ['SUBMITTED', 'PROPOSED', 'APPROVED', 'RECEIVED', 'REJECTED'])->default('SUBMITTED')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispensasi', function (Blueprint $table) {
            $table->enum('status_persetujuan', ['SUBMITTED', 'APPROVED', 'RECEIVED', 'REJECTED'])->default('SUBMITTED')->change();
        });
    }
};
