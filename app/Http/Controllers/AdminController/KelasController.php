<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index() {
        $kelas = Kelas::all();
        return view('admin.dataPokok.referensi.kelas', compact('kelas'));
    }

    public function store(Request $request) {
        $request->validate(['nama_kelas' => 'required|string']);
        Kelas::create($request->all());
        return back()->with('success', 'Data Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $request->validate(['nama_kelas' => 'required|string']);
        Kelas::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data Kelas diperbarui.');
    }

    public function destroy($id) {
        Kelas::findOrFail($id)->delete();
        return back()->with('success', 'Data Kelas dihapus.');
    }
}