<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\PengasuhanActivity; // Uncomment jika sudah menggunakan database

class PengasuhanController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan tanggal dari request, default hari ini
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // Dummy data menyesuaikan persis dengan gambar screenshot
        $kegiatans = [
            ['nama' => 'Bangun Tidur Pukul 04:30 WIB', 'selesai' => 10, 'total' => 33],
            ['nama' => 'Merapikan Tempat Tidur', 'selesai' => 10, 'total' => 11],
            ['nama' => 'Qiyamullail', 'selesai' => 10, 'total' => 11],
            ['nama' => 'Sholat Rawatib Subuh', 'selesai' => 10, 'total' => 11],
            ['nama' => 'Sholat Rawatib Dzuhur', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Sholat Rawatib Ashar', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Sholat Rawatib Maghrib', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Sholat Rawatib Isya', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Dzikir Pagi', 'selesai' => 10, 'total' => 11],
            ['nama' => 'Dzikir Sore', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Sholat Syuruq', 'selesai' => 10, 'total' => 11],
            ['nama' => 'Puasa Sunnah', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Belajar Malam', 'selesai' => 0, 'total' => 0],
            ['nama' => 'Tilawah/Muroja\'ah Alqur\'an 1/2 juz', 'selesai' => 0, 'total' => 0],
        ];

        /* * LOGIKA DATABASE (Contoh jika menggunakan database sesungguhnya):
         * $kegiatans = PengasuhanActivity::all()->map(function($kegiatan) {
         * return [
         * 'nama' => $kegiatan->nama_kegiatan,
         * 'selesai' => 10, // Dapatkan count dari tabel log/relasi siswa_kegiatan
         * 'total' => $kegiatan->target_siswa
         * ];
         * });
         */

        return view('admin.pengasuhan', compact('kegiatans', 'tanggal'));
    }
}