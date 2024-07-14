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
        Schema::table('asesmen_jadwal', function (Blueprint $table) {
            $table->dropForeign(['register_id']);
            $table->dropColumn('register_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesmen_jadwal', function (Blueprint $table) {
            $table->foreignUuid('register_id')->nullable()->constrained('register')->onDelete('cascade');
        });
    }
};
