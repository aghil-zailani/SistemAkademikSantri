<?php

namespace App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;

class ItemPelanggaranController extends Controller {
    public function index() {
        $pelanggaran = JenisPelanggaran::all();
        return view('admin.dataPokok.referensi.itemPelanggaran', compact('pelanggaran'));
    }
    public function store(Request $request) {
        JenisPelanggaran::create($request->all());
        return back()->with('success', 'Item Pelanggaran ditambahkan.');
    }
    public function update(Request $request, $id) {
        JenisPelanggaran::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data diperbarui.');
    }
    public function destroy($id) {
        JenisPelanggaran::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }
}