<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->foreignId('rombongan_belajar_id')->constrained('rombongan_belajars')->cascadeOnDelete();
            
            $table->string('jenis_ujian');
            $table->integer('kkm');
            $table->text('capaian_kompetensi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};