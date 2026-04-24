<?php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\EkstrakurikulerMentor;
use App\Models\EkstrakurikulerSiswa;
use App\Models\EkstrakurikulerKegiatan;
use App\Models\Student;
use App\Models\User;

class EkstrakurikulerController extends Controller
{
    // 1. Halaman Index (List Ekskul)
    public function index()
    {
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
        // FIX: load siswas.student (Student model) bukan siswas.user
        $ekskul = Ekstrakurikuler::with(['mentors.user', 'siswas.student'])->findOrFail($id);
        
        // Data untuk dropdown
        $teachers = User::where('role', 'teacher')->get();
        // FIX: gunakan Student model, bukan User dengan role student
        $students = Student::orderBy('nama_lengkap')->get();
        
        return view('admin.ekstrakurikuler.show', compact('ekskul', 'teachers', 'students'));
    }

    // 4. Halaman Kegiatan & Presensi
    public function kegiatan($id)
    {
        $ekskul = Ekstrakurikuler::with('kegiatans')->findOrFail($id);
        return view('admin.ekstrakurikuler.kegiatan', compact('ekskul'));
    }

    // 5. Tambah Mentor ke Ekskul
    public function tambahMentor(Request $request, $id)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'semester' => 'nullable|string',
        ]);

        // Cegah duplikasi mentor di semester yang sama
        $sudahAda = EkstrakurikulerMentor::where('ekstrakurikuler_id', $id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Mentor ini sudah terdaftar di ekstrakurikuler ini.');
        }

        EkstrakurikulerMentor::create([
            'ekstrakurikuler_id' => $id,
            'user_id'            => $request->user_id,
            'semester'           => $request->semester ?? 'Semester Ganjil',
        ]);

        return back()->with('success', 'Mentor berhasil ditambahkan.');
    }

    // 6. Tambah Siswa ke Ekskul
    public function tambahSiswa(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        // Cegah duplikasi siswa
        $sudahAda = EkstrakurikulerSiswa::where('ekstrakurikuler_id', $id)
            ->where('student_id', $request->student_id)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Siswa ini sudah terdaftar di ekstrakurikuler ini.');
        }

        EkstrakurikulerSiswa::create([
            'ekstrakurikuler_id' => $id,
            'student_id'         => $request->student_id,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    // 7. Hapus Mentor
    public function hapusMentor($ekskul_id, $mentor_id)
    {
        EkstrakurikulerMentor::findOrFail($mentor_id)->delete();
        return back()->with('success', 'Mentor berhasil dihapus.');
    }

    // 8. Hapus Siswa
    public function hapusSiswa($ekskul_id, $siswa_id)
    {
        EkstrakurikulerSiswa::findOrFail($siswa_id)->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    // 9. Tambah Kegiatan
    public function tambahKegiatan(Request $request, $id)
    {
        $request->validate([
            'tanggal'  => 'required|date',
            'ringkasan' => 'nullable|string',
        ]);

        EkstrakurikulerKegiatan::create([
            'ekstrakurikuler_id' => $id,
            'tanggal'            => $request->tanggal,
            'ringkasan'          => $request->ringkasan,
        ]);

        return back()->with('success', 'Kegiatan berhasil ditambahkan.');
    }
}