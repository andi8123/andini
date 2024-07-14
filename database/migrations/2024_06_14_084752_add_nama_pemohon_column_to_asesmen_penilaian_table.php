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
        Schema::table('asesmen_penilaian', function (Blueprint $table) {
            $table->string('nama_pemohon')->nullable()->after('asesor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesmen_penilaian', function (Blueprint $table) {
            $table->dropColumn('nama_pemohon');
        });
    }
};
