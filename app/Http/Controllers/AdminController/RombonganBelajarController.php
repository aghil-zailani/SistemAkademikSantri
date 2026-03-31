<?php

namespace App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RombonganBelajar;
use App\Models\User;

class RombonganBelajarController extends Controller {
    public function index() {
        $rombel = RombonganBelajar::with('waliKelas')->get();
        $gurus = User::where('role', 'teacher')->get(); // Untuk dropdown wali kelas
        return view('admin.dataPokok.referensi.rombonganBelajar', compact('rombel', 'gurus'));
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