<?php

namespace App\Http\Controllers\AdminController\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Akun;

class TagihanController extends Controller
{
    public function index()
    {    
        $tagihans = Tagihan::with(['akun', 'tagihanSiswas'])->latest()->paginate(10);
            
        foreach ($tagihans as $tagihan) {
            $tagihan->sudah_bayar_nominal = $tagihan->tagihanSiswas->where('status', 'success')->sum('jumlah');
            $tagihan->sudah_bayar_count   = $tagihan->tagihanSiswas->where('status', 'success')->count();
            $tagihan->belum_bayar_nominal = $tagihan->tagihanSiswas->where('status', 'pending')->sum('jumlah');
            $tagihan->belum_bayar_count   = $tagihan->tagihanSiswas->where('status', 'pending')->count();
        }

        return view('admin.keuangan.tagihan.index', compact('tagihans'));
    }

    public function show($id)
    {        
        $tagihan = Tagihan::with(['tagihanSiswas.student'])->findOrFail($id);
        return view('admin.keuangan.tagihan.show', compact('tagihan'));
    }

    public function create()
    {        
        $akuns = Akun::aktif()->orderBy('kode')->get(); 
        return view('admin.keuangan.tagihan.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'                => 'required|string|max:255',
            'akun_id'             => 'required|exists:akuns,id',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        Tagihan::create($request->only('nama', 'akun_id', 'tanggal_jatuh_tempo'));
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function edit(Tagihan $tagihan)
    {
        $akuns = Akun::aktif()->orderBy('kode')->get();
        return view('admin.keuangan.tagihan.edit', compact('tagihan', 'akuns'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'nama'                => 'required|string|max:255',
            'akun_id'             => 'required|exists:akuns,id',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $tagihan->update($request->only('nama', 'akun_id', 'tanggal_jatuh_tempo'));
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }
}
