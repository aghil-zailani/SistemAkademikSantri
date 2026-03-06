<?php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisPelanggaran;
use App\Models\Pelanggaran;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['user', 'jenisPelanggaran'])->latest()->get();
        // Ambil data siswa (sesuaikan 'role' dengan struktur Anda)
        $students = User::where('role', 'student')->get(); 
        $jenisPelanggarans = JenisPelanggaran::all();

        return view('admin.pelanggaran', compact('pelanggarans', 'students', 'jenisPelanggarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
        ]);

        Pelanggaran::create($request->all());

        return back()->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggarans,id',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update($request->all());

        return back()->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return back()->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}