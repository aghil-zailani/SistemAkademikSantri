<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class KesehatanController extends Controller
{
    // 1. Tampil Daftar Rekam Medis
    public function index()
    {
        $rekamMedis = RekamMedis::with(['siswa', 'petugasMasuk', 'petugasKeluar'])
            ->orderBy('tanggal_masuk', 'desc')
            ->get();
        return view('admin.kesehatan.index', compact('rekamMedis'));
    }

    // 2. Form Tambah Data Masuk Klinik
    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.kesehatan.create', compact('students'));
    }

    // 3. Simpan Data Masuk Klinik
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'keluhan_masuk' => 'required|string',
        ]);

        RekamMedis::create([
            'user_id' => $request->user_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keluhan_masuk' => $request->keluhan_masuk,
            'petugas_masuk_id' => Auth::id(), // Petugas yang sedang login
        ]);

        return redirect()->route('kesehatan.index')->with('success', 'Data rekam medis berhasil ditambahkan.');
    }

    // 4. Form Edit Data Masuk Klinik
    public function edit($id)
    {
        $rekam = RekamMedis::findOrFail($id);
        $students = User::where('role', 'student')->get();
        return view('admin.kesehatan.edit', compact('rekam', 'students'));
    }

    // 5. Update Data Masuk Klinik
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'keluhan_masuk' => 'required|string',
        ]);

        $rekam = RekamMedis::findOrFail($id);
        $rekam->update([
            'user_id' => $request->user_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keluhan_masuk' => $request->keluhan_masuk,
        ]);

        return redirect()->route('kesehatan.index')->with('success', 'Data rekam medis berhasil diperbarui.');
    }

    // 6. Form Keterangan Keluar Klinik
    public function editKeluar($id)
    {
        $rekam = RekamMedis::with(['siswa', 'petugasMasuk'])->findOrFail($id);
        return view('admin.kesehatan.keluar', compact('rekam'));
    }

    // 7. Update Keterangan Keluar Klinik
    public function updateKeluar(Request $request, $id)
    {
        $request->validate([
            'tanggal_keluar' => 'required|date',
            'keterangan_keluar' => 'required|string',
        ]);

        $rekam = RekamMedis::findOrFail($id);
        $rekam->update([
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan_keluar' => $request->keterangan_keluar,
            'petugas_keluar_id' => Auth::id(), // Petugas yang mengurus proses keluar
        ]);

        return redirect()->route('kesehatan.index')->with('success', 'Data keluar klinik berhasil disimpan.');
    }

    // 8. Hapus Rekam Medis
    public function destroy($id)
    {
        RekamMedis::findOrFail($id)->delete();
        return redirect()->route('kesehatan.index')->with('success', 'Data berhasil dihapus.');
    }
}