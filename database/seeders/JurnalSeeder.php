<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurnal;
use App\Models\JurnalItem;
use App\Models\User;
use Carbon\Carbon;

class JurnalSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JurnalItem::truncate();
        Jurnal::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::first();

        // Jurnal templates: typical double-entry accounting transactions
        // Each template = [debit_akun, credit_akun, keterangan_template, nominal_range]
        $templates = [
            [
                'debit'   => '2.01.01 - Deposit Siswa',
                'credit'  => '2.01.03 - Deposit Air Mart',
                'note'    => 'Belanja Air Mart',
                'range'   => [3_000, 15_000],
            ],
            [
                'debit'   => '2.01.01 - Deposit Siswa',
                'credit'  => '2.01.04 - Deposit Kantin',
                'note'    => 'Belanja Kantin',
                'range'   => [5_000, 25_000],
            ],
            [
                'debit'   => '1.01.02 - Bank BSI (PIAT12)',
                'credit'  => '2.01.01 - Deposit Siswa',
                'note'    => 'Top Up Deposit Siswa',
                'range'   => [100_000, 2_000_000],
            ],
            [
                'debit'   => '2.01.01 - Deposit Siswa',
                'credit'  => '2.01.02 - Deposit SPP',
                'note'    => 'Pembayaran SPP',
                'range'   => [1_850_000, 1_850_000],
            ],
            [
                'debit'   => '1.01.02 - Bank BSI (PIAT12)',
                'credit'  => '4.01.04 - Pendapatan SPP',
                'note'    => 'Penerimaan SPP',
                'range'   => [1_850_000, 3_700_000],
            ],
            [
                'debit'   => '2.01.01 - Deposit Siswa',
                'credit'  => '2.01.05 - Deposit Laundry',
                'note'    => 'Pembayaran Laundry',
                'range'   => [30_000, 150_000],
            ],
            [
                'debit'   => '1.01.02 - Bank BSI (PIAT12)',
                'credit'  => '4.01.01 - Pendapatan Air Mart',
                'note'    => 'Setoran Air Mart',
                'range'   => [100_000, 800_000],
            ],
            [
                'debit'   => '1.01.02 - Bank BSI (PIAT12)',
                'credit'  => '4.01.02 - Pendapatan Kantin',
                'note'    => 'Setoran Kantin Harian',
                'range'   => [200_000, 1_500_000],
            ],
            [
                'debit'   => '2.01.01 - Deposit Siswa',
                'credit'  => '2.01.06 - Deposit Seragam',
                'note'    => 'Pembelian Seragam',
                'range'   => [160_000, 480_000],
            ],
            [
                'debit'   => '1.01.01 - Kas Kecil',
                'credit'  => '1.01.02 - Bank BSI (PIAT12)',
                'note'    => 'Penarikan Kas Kecil',
                'range'   => [500_000, 2_000_000],
            ],
        ];

        $namaSiswa = [
            'MUHAMMAD ATHAYA ARISKA', 'MUHAMAD RAMOS SATRIADHI', 'HANIF ABDURRAHMAN',
            'ABDURROFI AL LABIB', 'AHMAD DZAKY PUTRA', 'KEMAL AL BARIQ',
            'HABIB DZAKWAN ANANTO', 'GHAISAN AZKA RAMADHAN', 'ABDAN SYAKURO RASYA',
            'ABDURRAHMAN', 'ALERI ARKHAN YUSUF FERLINDO', 'OZIL MULYADI PUTRA',
            'AHMAD FARIS KHUSNI', 'MUHAMMAD IZZUL ISLAM', 'M. NAZEEFIRLO ZUFAREY',
            'MU\'TASHIM WAFI ABDURRAHMAN', 'MUHAMMAD AQIL ABHISTA',
        ];

        // Generate 4 months Jan-Apr 2026
        foreach ([1, 2, 3, 4] as $bulan) {
            // 20-25 journal entries per month
            $count = rand(20, 25);
            for ($i = 0; $i < $count; $i++) {
                $template = $templates[array_rand($templates)];
                $nama     = $namaSiswa[array_rand($namaSiswa)];
                $nominal  = rand($template['range'][0], $template['range'][1]);
                $namaUser = $user ? $user->name : 'Administrator';

                // Random datetime within the month
                $daysInMonth = Carbon::create(2026, $bulan)->daysInMonth;
                $tanggal = Carbon::create(
                    2026, $bulan,
                    rand(1, $daysInMonth),
                    rand(8, 17),
                    rand(0, 59),
                    rand(0, 59)
                );

                $jurnal = Jurnal::create([
                    'user_id' => $user->id ?? null,
                    'tanggal' => $tanggal,
                ]);

                $catatan = $template['note'] . ' : ' . $nama;

                // Debit line
                JurnalItem::create([
                    'jurnal_id' => $jurnal->id,
                    'akun'      => $template['debit'],
                    'posisi'    => 'debit',
                    'nominal'   => $nominal,
                    'catatan'   => $catatan,
                ]);

                // Credit line
                JurnalItem::create([
                    'jurnal_id' => $jurnal->id,
                    'akun'      => $template['credit'],
                    'posisi'    => 'credit',
                    'nominal'   => $nominal,
                    'catatan'   => $catatan,
                ]);
            }
        }
    }
}
