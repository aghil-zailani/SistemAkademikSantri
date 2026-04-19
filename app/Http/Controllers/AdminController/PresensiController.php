<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Student;
use App\Models\RombonganBelajar;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{   
    public function index(Request $request)
    {
        $rombels = RombonganBelajar::all();
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $rombel_id = $request->input('rombongan_belajar_id');

        $query = Presensi::with(['student', 'mataPelajaran', 'rombonganBelajar'])
                         ->where('tanggal', $tanggal);

        if ($rombel_id) {
            $query->where('rombongan_belajar_id', $rombel_id);
        }

        $presensis = $query->orderBy('student_id')->paginate(20);

        return view('admin.presensi.index', compact('presensis', 'rombels', 'tanggal', 'rombel_id'));
    }

    public function create()
    {
        $rombels = RombonganBelajar::all();
        $mataPelajarans = MataPelajaran::all();
        
        return view('admin.presensi.create', compact('rombels', 'mataPelajarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'rombongan_belajar_id' => 'required',
            'status' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->status as $student_id => $status) {
                $keterangan = $request->keterangan[$student_id] ?? null;
                
                Presensi::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'tanggal' => $request->tanggal,
                        'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    ],
                    [
                        'rombongan_belajar_id' => $request->rombongan_belajar_id,
                        'status' => $status,
                        'keterangan' => $keterangan
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.presensi.index', [
                'tanggal' => $request->tanggal,
                'rombongan_belajar_id' => $request->rombongan_belajar_id
            ])->with('success', 'Data presensi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getStudentsForPresensi(Request $request)
    {
        $rombel_id = $request->rombel_id;
        $tanggal = $request->tanggal;
        $mapel_id = $request->mapel_id;

        $students = Student::where('rombongan_belajar_id', $rombel_id)->orderBy('name', 'asc')->get();

        $existingPresensi = Presensi::where('rombongan_belajar_id', $rombel_id)
            ->where('tanggal', $tanggal)
            ->where('mata_pelajaran_id', $mapel_id)
            ->pluck('status', 'student_id')
            ->toArray();

        $existingKeterangan = Presensi::where('rombongan_belajar_id', $rombel_id)
            ->where('tanggal', $tanggal)
            ->where('mata_pelajaran_id', $mapel_id)
            ->pluck('keterangan', 'student_id')
            ->toArray();

        $data = $students->map(function($student) use ($existingPresensi, $existingKeterangan) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'status' => $existingPresensi[$student->id] ?? 'Hadir',
                'keterangan' => $existingKeterangan[$student->id] ?? ''
            ];
        });

        return response()->json($data);
    }
}