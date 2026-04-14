<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BukuBesar;
use Carbon\Carbon;

class BukuBesarSeeder extends Seeder
{
    public function run(): void
    {
        BukuBesar::truncate();

        $akuns = [
            '1.01.01 - Kas Kecil' => [
                'open_awal' => 5_000_000,
                'jenis'     => 'campur',
                'keterangan_debit'  => ['Penerimaan Kas Operasional', 'Setor Tunai Kantin', 'Setor Tunai Air Mart', 'Penerimaan Iuran Harian'],
                'keterangan_credit' => ['Pengeluaran Kas Kecil', 'Bayar ATK', 'Bayar Kebersihan', 'Bayar Transport'],
                'range_debit'  => [50_000, 2_000_000],
                'range_credit' => [50_000, 1_500_000],
            ],
            '1.01.02 - Bank BSI (PIAT12)' => [
                'open_awal' => 90_439_648,
                'jenis'     => 'masuk',
                'keterangan_debit'  => ['Top Up', 'Transfer Masuk SPP', 'Setor Tabungan', 'Penerimaan VA'],
                'keterangan_credit' => [],
                'range_debit'  => [500_000, 5_000_000],
                'range_credit' => [0, 0],
            ],
            '2.01.01 - Deposit Siswa' => [
                'open_awal' => 9_786_451,
                'jenis'     => 'campur',
                'keterangan_debit'  => ['Top Up Deposit Siswa'],
                'keterangan_credit' => ['Penarikan Deposit Siswa', 'Penggunaan Deposit'],
                'range_debit'  => [100_000, 2_000_000],
                'range_credit' => [100_000, 1_500_000],
            ],
            '2.01.02 - Deposit SPP' => [
                'open_awal' => 0,
                'jenis'     => 'keluar',
                'keterangan_debit'  => [],
                'keterangan_credit' => ['Pembayaran SPP', 'Bayar SPP Bulan Berjalan'],
                'range_debit'  => [0, 0],
                'range_credit' => [1_850_000, 3_700_000],
            ],
            '2.01.03 - Deposit Air Mart' => [
                'open_awal' => 13_517_501,
                'jenis'     => 'keluar',
                'keterangan_debit'  => [],
                'keterangan_credit' => ['Pembelian Air Mart', 'Transaksi Air Mart'],
                'range_debit'  => [0, 0],
                'range_credit' => [20_000, 200_000],
            ],
            '2.01.04 - Deposit Kantin' => [
                'open_awal' => 1_529_096,
                'jenis'     => 'keluar',
                'keterangan_debit'  => [],
                'keterangan_credit' => ['Transaksi Kantin', 'Makan Siang', 'Makan Pagi'],
                'range_debit'  => [0, 0],
                'range_credit' => [5_000, 50_000],
            ],
            '2.01.05 - Deposit Laundry' => [
                'open_awal' => 1_926_600,
                'jenis'     => 'keluar',
                'keterangan_debit'  => [],
                'keterangan_credit' => ['Biaya Laundry Bulanan', 'Laundry Mingguan'],
                'range_debit'  => [0, 0],
                'range_credit' => [30_000, 150_000],
            ],
            '2.01.06 - Deposit Seragam' => [
                'open_awal' => 4_480_000,
                'jenis'     => 'keluar',
                'keterangan_debit'  => [],
                'keterangan_credit' => ['Pembelian Seragam', 'Pelunasan Seragam Baru'],
                'range_debit'  => [0, 0],
                'range_credit' => [160_000, 500_000],
            ],
            '4.01.01 - Pendapatan Air Mart' => [
                'open_awal' => 0,
                'jenis'     => 'masuk',
                'keterangan_debit'  => ['Penjualan Air Mart', 'Setoran Harian Air Mart'],
                'keterangan_credit' => [],
                'range_debit'  => [100_000, 1_000_000],
                'range_credit' => [0, 0],
            ],
            '4.01.02 - Pendapatan Kantin' => [
                'open_awal' => 0,
                'jenis'     => 'masuk',
                'keterangan_debit'  => ['Penjualan Kantin Harian', 'Setoran Kantin'],
                'keterangan_credit' => [],
                'range_debit'  => [200_000, 2_000_000],
                'range_credit' => [0, 0],
            ],
            '4.01.04 - Pendapatan SPP' => [
                'open_awal' => 0,
                'jenis'     => 'masuk',
                'keterangan_debit'  => ['Penerimaan SPP', 'Pelunasan Tunggakan SPP'],
                'keterangan_credit' => [],
                'range_debit'  => [1_850_000, 3_700_000],
                'range_credit' => [0, 0],
            ],
        ];

        $namaSiswa = [
            'ALERI ARKHAN YUSUF FERLINDO', 'OZIL MULYADI PUTRA', 'MUHAMMAD IZZUL ISLAM',
            'AHMAD FARIS KHUSNI', 'MUHAMAD RAMOS SATRIADHI', 'HANIF ABDURRAHMAN',
            'ABDURROFI AL LABIB', 'MUHAMMAD ATHAYA ARISKA', 'AHMAD DZAKY PUTRA',
            'KEMAL AL BARIQ', 'HABIB DZAKWAN ANANTO', 'GHAISAN AZKA RAMADHAN',
            'MUHAMMAD ABDUL BASITH YUDA AL AGAMY', 'ABDAN SYAKURO RASYA', 'ABDURRAHMAN',
        ];

        // Generate data for Jan - Apr 2026
        foreach ($akuns as $akunName => $config) {
            $currentBalance = $config['open_awal'];

            // Generate 4 months (Jan, Feb, Mar, Apr 2026)
            foreach ([1, 2, 3, 4] as $bulan) {
                $date = Carbon::create(2026, $bulan, 1, 7, 0, 0);
                $endDate = $date->copy()->endOfMonth();

                // 20-30 rows per akun per month
                $count = rand(20, 30);
                for ($i = 0; $i < $count; $i++) {
                    $debit  = 0;
                    $credit = 0;
                    $keterangan = '';
                    $nama = $namaSiswa[array_rand($namaSiswa)];

                    if ($config['jenis'] === 'masuk') {
                        $debit = rand($config['range_debit'][0], $config['range_debit'][1]);
                        $label = $config['keterangan_debit'][array_rand($config['keterangan_debit'])];
                        $keterangan = $label . ' - ' . $nama;
                    } elseif ($config['jenis'] === 'keluar') {
                        $credit = rand($config['range_credit'][0], $config['range_credit'][1]);
                        $label = $config['keterangan_credit'][array_rand($config['keterangan_credit'])];
                        $keterangan = $label . ' - ' . $nama;
                    } else { // campur
                        if (rand(0, 1) === 0 && !empty($config['keterangan_debit'])) {
                            $debit = rand($config['range_debit'][0], $config['range_debit'][1]);
                            $label = $config['keterangan_debit'][array_rand($config['keterangan_debit'])];
                            $keterangan = $label . ' ' . $nama;
                        } else {
                            $credit = rand($config['range_credit'][0], $config['range_credit'][1]);
                            $label = $config['keterangan_credit'][array_rand($config['keterangan_credit'])];
                            $keterangan = $label . ' ' . $nama;
                        }
                    }

                    $close = $currentBalance + $debit - $credit;

                    BukuBesar::create([
                        'akun'         => $akunName,
                        'tanggal'      => $date->copy()->addMinutes(rand(0, (int)$date->diffInMinutes($endDate))),
                        'keterangan'   => $keterangan,
                        'open'         => $currentBalance,
                        'debit'        => $debit,
                        'credit'       => $credit,
                        'close'        => $close,
                    ]);

                    $currentBalance = $close;
                }

                $date->addMonth();
            }
        }
    }
}

