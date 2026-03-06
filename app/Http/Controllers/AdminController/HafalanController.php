<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Surah;
use App\Models\Hafalan;
use App\Models\SetoranHafalan;

class HafalanController extends Controller
{
    // 1. Menampilkan daftar siswa
    public function index(Request $request)
    {
        // Ganti dengan query user role 'student' milik Anda
        $students = User::where('role', 'student')->get(); 
        return view('admin.hafalan.index', compact('students'));
    }

    // 2. Menampilkan list Surah & Progress per Siswa
    public function show($user_id)
    {
        $student = User::findOrFail($user_id);
        $surahs = Surah::all();
        
        // Ambil data hafalan siswa ini untuk map progress
        $hafalans = Hafalan::where('user_id', $user_id)->get()->keyBy('surah_id');

        return view('admin.hafalan.show', compact('student', 'surahs', 'hafalans'));
    }

    // 3. Menyimpan Setoran dari Modal
    public function storeSetoran(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'surah_id' => 'required',
            'ayat_mulai' => 'required|numeric',
            'ayat_selesai' => 'required|numeric',
            'nilai' => 'nullable|numeric|min:0|max:100'
        ]);

        // Cari atau buat record Hafalan utama
        $hafalan = Hafalan::firstOrCreate(
            ['user_id' => $request->user_id, 'surah_id' => $request->surah_id]
        );

        // Update ayat terakhir dan status
        $surah = Surah::find($request->surah_id);
        $hafalan->ayat_terakhir = max($hafalan->ayat_terakhir, $request->ayat_selesai);
        if ($hafalan->ayat_terakhir >= $surah->total_ayat) {
            $hafalan->status = 'Selesai';
        }
        $hafalan->save();

        // Simpan Detail Setoran
        SetoranHafalan::create([
            'hafalan_id' => $hafalan->id,
            'ayat_mulai' => $request->ayat_mulai,
            'ayat_selesai' => $request->ayat_selesai,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Setoran berhasil disimpan!');
    }

    // 4. Detail Riwayat Setoran per Surah
    public function detail($user_id, $surah_id)
    {
        $student = User::findOrFail($user_id);
        $surah = Surah::findOrFail($surah_id);
        $hafalan = Hafalan::with('setorans')->where('user_id', $user_id)->where('surah_id', $surah_id)->first();

        return view('admin.hafalan.detail', compact('student', 'surah', 'hafalan'));
    }
}