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
        Schema::create('setoran_hafalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hafalan_id')->constrained('hafalans')->onDelete('cascade');
            $table->integer('ayat_mulai');
            $table->integer('ayat_selesai');
            $table->integer('nilai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran_hafalans');
    }
};
