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
            $table->text('lama_hubungan')->nullable()->change();
            $table->text('alasan_menikah')->nullable()->change();
            $table->text('gaya_berpacaran')->nullable()->change();
            $table->text('pekerjaan_catin')->nullable()->change();
            $table->text('penghasilan_catin')->nullable()->change();
            $table->text('persetujuan_keluarga')->nullable()->change();
            $table->text('pola_hubungan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('text_on_asesmen_penilaian', function (Blueprint $table) {
            $table->string('lama_hubungan')->nullable()->change();
            $table->string('alasan_menikah')->nullable()->change();
            $table->string('gaya_berpacaran')->nullable()->change();
            $table->string('pekerjaan_catin')->nullable()->change();
            $table->string('penghasilan_catin')->nullable()->change();
            $table->string('persetujuan_keluarga')->nullable()->change();
            $table->string('pola_hubungan')->nullable()->change();
        });
    }
};
