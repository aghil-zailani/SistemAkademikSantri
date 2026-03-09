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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Siswa
                        
            $table->date('tanggal_masuk');
            $table->text('keluhan_masuk');
            $table->foreignId('petugas_masuk_id')->constrained('users')->onDelete('cascade'); // ID Admin/Guru
            
            // Data Keluar Klinik
            $table->date('tanggal_keluar')->nullable();
            $table->text('keterangan_keluar')->nullable();
            $table->foreignId('petugas_keluar_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
