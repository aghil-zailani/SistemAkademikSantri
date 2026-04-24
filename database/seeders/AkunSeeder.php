<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Data akun buku besar pesantren (Chart of Accounts).
     * Sesuai dengan data yang terlihat di sistem (dari referensi).
     */
    public function run(): void
    {
        $akuns = [
            // =============================================
            // 1. ASET (Harta)
            // =============================================
            ['kode' => '1.01.01', 'nama' => 'Kas Kecil',       'tipe' => 'aset'],
            ['kode' => '1.01.02', 'nama' => 'Bank BSI (PIAT12)', 'tipe' => 'aset'],
            ['kode' => '1.02.01', 'nama' => 'Piutang SPP',      'tipe' => 'aset'],
            ['kode' => '1.02.02', 'nama' => 'Piutang Lainnya',  'tipe' => 'aset'],

            // =============================================
            // 2. KEWAJIBAN / DEPOSIT (Titipan siswa)
            // =============================================
            ['kode' => '2.01.01', 'nama' => 'Deposit Siswa',    'tipe' => 'kewajiban'],
            ['kode' => '2.01.02', 'nama' => 'Deposit SPP',      'tipe' => 'kewajiban'],
            ['kode' => '2.01.03', 'nama' => 'Deposit Air Mart', 'tipe' => 'kewajiban'],
            ['kode' => '2.01.04', 'nama' => 'Deposit Kantin',   'tipe' => 'kewajiban'],
            ['kode' => '2.01.05', 'nama' => 'Deposit Laundry',  'tipe' => 'kewajiban'],
            ['kode' => '2.01.06', 'nama' => 'Deposit Seragam',  'tipe' => 'kewajiban'],

            // =============================================
            // 3. MODAL
            // =============================================
            ['kode' => '3.01.01', 'nama' => 'Modal Yayasan',    'tipe' => 'modal'],

            // =============================================
            // 4. PENDAPATAN
            // =============================================
            ['kode' => '4.01.01', 'nama' => 'Pendapatan Air Mart',     'tipe' => 'pendapatan'],
            ['kode' => '4.01.02', 'nama' => 'Pendapatan Kantin',       'tipe' => 'pendapatan'],
            ['kode' => '4.01.03', 'nama' => 'Pendapatan Laundry',      'tipe' => 'pendapatan'],
            ['kode' => '4.01.04', 'nama' => 'Pendapatan SPP',          'tipe' => 'pendapatan'],
            ['kode' => '4.01.05', 'nama' => 'Pendapatan Uang Gedung',  'tipe' => 'pendapatan'],
            ['kode' => '4.01.06', 'nama' => 'Pendapatan Seragam',      'tipe' => 'pendapatan'],
            ['kode' => '4.01.07', 'nama' => 'Pendapatan Lainnya',      'tipe' => 'pendapatan'],

            // =============================================
            // 5. BEBAN / PENGELUARAN
            // =============================================
            ['kode' => '5.01.01', 'nama' => 'Beban Gaji Pegawai',     'tipe' => 'beban'],
            ['kode' => '5.01.02', 'nama' => 'Beban Operasional',      'tipe' => 'beban'],
            ['kode' => '5.01.03', 'nama' => 'Beban Pemeliharaan',     'tipe' => 'beban'],
        ];

        foreach ($akuns as &$akun) {
            $akun['is_aktif']   = true;
            $akun['created_at'] = now();
            $akun['updated_at'] = now();
        }

        DB::table('akuns')->insert($akuns);

        $this->command->info('✅ ' . count($akuns) . ' data akun berhasil di-seed.');
    }
}
