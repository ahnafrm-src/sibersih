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
    Schema::create('laporan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
        $table->foreignId('kelas_terduga_id')->nullable()->constrained('kelas')->nullOnDelete();
        $table->string('nama_pelapor')->nullable();
        $table->string('kelas_pelapor')->nullable();
        
        $table->string('foto');
        $table->timestamp('waktu_lapor');
        $table->enum('status', ['baru', 'ditindak', 'selesai', 'disanggah'])->default('baru');
        $table->string('catatan_koreksi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
