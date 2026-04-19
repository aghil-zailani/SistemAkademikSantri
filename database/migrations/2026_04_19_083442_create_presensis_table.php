<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('rombongan_belajar_id')->constrained('rombongan_belajars')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->nullable()->constrained('mata_pelajarans')->cascadeOnDelete();
            
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa'])->default('Hadir');
            $table->string('keterangan')->nullable();
            
            $table->timestamps();
            
            $table->unique(['student_id', 'tanggal', 'mata_pelajaran_id'], 'presensi_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};