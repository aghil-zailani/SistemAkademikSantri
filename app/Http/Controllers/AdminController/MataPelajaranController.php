<?php

namespace App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller {
    public function index() {
        $mapel = MataPelajaran::all();
        return view('admin.dataPokok.referensi.mataPelajaran', compact('mapel'));
    }
    public function store(Request $request) {
        MataPelajaran::create($request->all());
        return back()->with('success', 'Mata Pelajaran ditambahkan.');
    }
    public function update(Request $request, $id) {
        MataPelajaran::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data diperbarui.');
    }
    public function destroy($id) {
        MataPelajaran::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }
}