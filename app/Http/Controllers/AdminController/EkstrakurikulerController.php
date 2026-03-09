<?php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\EkstrakurikulerKegiatan;
use App\Models\User;

class EkstrakurikulerController extends Controller
{
    // 1. Halaman Index (List Ekskul)
    public function index()
    {
        // Load relasi user di dalam mentors untuk menampilkan namanya
        $ekskuls = Ekstrakurikuler::with(['mentors.user', 'siswas'])->get();
        return view('admin.ekstrakurikuler.index', compact('ekskuls'));
    }

    // 2. Simpan Ekskul Baru
    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string']);
        Ekstrakurikuler::create($request->all());
        return back()->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    // 3. Halaman Detail (Manajemen Mentor & Siswa)
    public function show($id)
    {
        $ekskul = Ekstrakurikuler::with(['mentors.user', 'siswas.user'])->findOrFail($id);
        
        // Data untuk dropdown
        $teachers = User::where('role', 'teacher')->get();
        $students = User::where('role', 'student')->get();
        
        return view('admin.ekstrakurikuler.show', compact('ekskul', 'teachers', 'students'));
    }

    // 4. Halaman Kegiatan & Presensi
    public function kegiatan($id)
    {
        $ekskul = Ekstrakurikuler::with('kegiatans')->findOrFail($id);
        return view('admin.ekstrakurikuler.kegiatan', compact('ekskul'));
    }

    // (Opsional/Bisa ditambahkan) Method tambahMentor & tambahSiswa untuk insert ke tabel pivot
}