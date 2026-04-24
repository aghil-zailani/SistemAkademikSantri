<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihan_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            
            $table->decimal('jumlah', 15, 2)->default(0); // Nominal tagihan untuk siswa ini
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->dateTime('tanggal_bayar')->nullable();
            
            $table->timestamps();

            // Mencegah 1 siswa ditagih 2 kali untuk tagihan yang sama
            $table->unique(['tagihan_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan_siswas');
    }
};