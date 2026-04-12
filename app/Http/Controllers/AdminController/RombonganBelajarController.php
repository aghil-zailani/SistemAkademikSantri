<?php

namespace App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RombonganBelajar;
use App\Models\User;
use App\Models\Kelas;

class RombonganBelajarController extends Controller {
    public function index() {
        $rombel = RombonganBelajar::with('waliKelas')->get();
        $gurus = User::where('role', 'teacher')->get(); // Untuk dropdown wali kelas
        $data_kelas = Kelas::all();

        return view('admin.dataPokok.referensi.rombonganBelajar', compact('rombel', 'gurus', 'data_kelas'));
    }
    public function store(Request $request) {
        RombonganBelajar::create($request->all());
        return back()->with('success', 'Rombongan Belajar ditambahkan.');
    }
    public function update(Request $request, $id) {
        RombonganBelajar::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data diperbarui.');
    }
    public function destroy($id) {
        RombonganBelajar::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }
}