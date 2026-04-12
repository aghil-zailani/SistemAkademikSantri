<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kbms;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class KbmController extends Controller
{
    public function index()
    {
        $kbms = Kbms::with(['guru','kelas','mataPelajaran'])->latest()->get();
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();

        return view('admin.KegiatanBelajar',compact('kbms','kelas','mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'materi' => 'required'
        ]);

        $jamPembelajaran = $request->jam_mulai . ' - ' . $request->jam_selesai;

        $metode = $request->input('metode_pembelajaran', []);

        Kbms::create([
            'tanggal' => $request->tanggal,
            'guru_id' => auth()->id(),
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'jam_pembelajaran' => $jamPembelajaran,
            'materi' => $request->materi,
            'sub_materi' => $request->sub_materi,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'metode_ceramah'=>in_array('ceramah',$metode),
            'metode_diskusi'=>in_array('diskusi',$metode),
            'metode_tanya_jawab'=>in_array('tanya_jawab',$metode),
            'metode_praktek'=>in_array('praktek',$metode),
        ]);

        return redirect()->back()->with('success','KBM berhasil disimpan');
    }
}
