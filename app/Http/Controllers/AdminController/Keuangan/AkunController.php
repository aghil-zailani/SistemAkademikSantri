<?php

namespace App\Http\Controllers\AdminController\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akun;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = Akun::orderBy('kode')->get();
        return view('admin.keuangan.akun.index', compact('akuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:akuns,kode',
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
        ]);

        Akun::create($request->only('kode', 'nama', 'tipe'));
        return back()->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, Akun $akun)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:akuns,kode,' . $akun->id,
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
        ]);

        $akun->update($request->only('kode', 'nama', 'tipe'));
        return back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(Akun $akun)
    {
        // Cegah hapus jika masih dipakai tagihan
        if ($akun->tagihans()->exists()) {
            return back()->with('error', 'Akun tidak bisa dihapus karena masih digunakan oleh tagihan.');
        }

        $akun->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }

    // Toggle aktif/nonaktif
    public function toggleAktif(Akun $akun)
    {
        $akun->update(['is_aktif' => !$akun->is_aktif]);
        $status = $akun->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun berhasil {$status}.");
    }
}
