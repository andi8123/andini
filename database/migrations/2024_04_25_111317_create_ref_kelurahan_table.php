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
        Schema::create('ref_kelurahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('ref_kecamatan')->onUpdate('cascade')->onDelete('restrict');
            $table->string('kode_kelurahan', 10)->unique();
            $table->string('nama_kelurahan');
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('is_active', ['1', '0'])->default('1')->comment('1 = Aktif, 0 = Tidak Aktif');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kelurahan');
    }
};