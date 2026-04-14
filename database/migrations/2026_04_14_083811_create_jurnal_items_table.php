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
        Schema::create('jurnal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurnal_id')->constrained()->cascadeOnDelete();
            $table->string('akun');
            $table->enum('posisi', ['debit', 'credit']);
            $table->decimal('nominal', 15, 2);
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_items');
    }
};
