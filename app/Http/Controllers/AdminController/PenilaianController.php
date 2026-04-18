<?php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\MataPelajaran; 
use App\Models\RombonganBelajar; 
use App\Models\Student; 
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = Penilaian::with(['mataPelajaran', 'rombonganBelajar']);
        
        if ($request->filled('jenis_ujian') && $request->jenis_ujian != 'Semua') {
            $query->where('jenis_ujian', $request->jenis_ujian);
        }

        $penilaians = $query->latest()->paginate(10);
        
        return view('admin.penilaian.index', compact('penilaians'));
    }

    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        $rombels = RombonganBelajar::all();
        
        return view('admin.penilaian.create', compact('mataPelajarans', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required',
            'rombongan_belajar_id' => 'required',
            'jenis_ujian' => 'required',
            'kkm' => 'required|numeric',
            'nilai' => 'required|array', 
        ]);

        DB::beginTransaction();
        try {
            $penilaian = Penilaian::create([
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'rombongan_belajar_id' => $request->rombongan_belajar_id,
                'jenis_ujian' => $request->jenis_ujian,
                'kkm' => $request->kkm,
                'capaian_kompetensi' => $request->capaian_kompetensi,
            ]);

            foreach ($request->nilai as $student_id => $nilai_siswa) {
                PenilaianDetail::create([
                    'penilaian_id' => $penilaian->id,
                    'student_id' => $student_id,
                    'nilai' => $nilai_siswa ?? 0,
                ]);
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('success', 'Data nilai berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function getStudentsByRombel($rombel_id)
    {
        $students = Student::where('rombongan_belajar_id', $rombel_id)->orderBy('name', 'asc')->get();
        return response()->json($students);
    }
}