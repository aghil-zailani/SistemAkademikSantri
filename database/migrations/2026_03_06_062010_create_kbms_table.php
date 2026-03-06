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
        Schema::create('kbms', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');

            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();

            $table->string('jam_pembelajaran')->nullable();

            $table->text('materi')->nullable();
            $table->text('sub_materi')->nullable();

            $table->enum('status', ['selesai','belum_selesai'])->default('belum_selesai');

            $table->text('catatan')->nullable();

            $table->boolean('metode_ceramah')->default(false);
            $table->boolean('metode_diskusi')->default(false);
            $table->boolean('metode_tanya_jawab')->default(false);
            $table->boolean('metode_praktek')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kbms');
    }
};
