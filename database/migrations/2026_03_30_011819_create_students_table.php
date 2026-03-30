<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Relasi ke akun login (opsional)
            $table->string('nama_lengkap');
            $table->string('nisn')->unique();
            $table->string('nis')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('id_kartu')->nullable()->unique();
            $table->string('va_number')->nullable(); // Untuk Virtual Account
            $table->string('sekolah')->default('Pesantren Islam Al-Irsyad'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};