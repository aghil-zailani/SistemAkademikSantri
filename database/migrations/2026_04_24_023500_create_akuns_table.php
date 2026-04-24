<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();   // contoh: '1.01.01', '4.01.02'
            $table->string('nama');                  // contoh: 'Kas Kecil', 'Pendapatan SPP'
            $table->enum('tipe', [
                'aset',         // Harta (kode 1.xx.xx)
                'kewajiban',    // Hutang / Deposit (kode 2.xx.xx)
                'modal',        // Ekuitas (kode 3.xx.xx)
                'pendapatan',   // Pemasukan (kode 4.xx.xx)
                'beban',        // Pengeluaran (kode 5.xx.xx)
            ]);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akuns');
    }
};
