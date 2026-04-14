<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\TagihanStudent;
use App\Models\Student;

class TagihanController extends Controller
{
    private $akunOptions = [
        '1.01.01 - Kas Kecil',
        '1.01.02 - Bank BSI (PIAT12)',
        '2.01.01 - Deposit Siswa',
        '2.01.02 - Deposit SPP',
        '2.01.03 - Deposit Air Mart',
        '2.01.04 - Deposit Kantin',
        '2.01.05 - Deposit Laundry',
        '2.01.06 - Deposit Seragam',
        '4.01.01 - Pendapatan Air Mart',
        '4.01.02 - Pendapatan Kantin',
        '4.01.04 - Pendapatan SPP'
    ];

    public function index()
    {
        $tagihans = Tagihan::with('students')->latest()->paginate(10);
        return view('admin.keuangan.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $akunOptions = $this->akunOptions;
        return view('admin.keuangan.tagihan.create', compact('akunOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'akun' => 'required|string',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        Tagihan::create([
            'nama' => $request->nama,
            'akun' => $request->akun,
            'tanggal_jatuh_tempo' => date('Y-m-d', strtotime($request->tanggal_jatuh_tempo)),
        ]);

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
    }

    public function show($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihanStudents = TagihanStudent::with('student')->where('tagihan_id', $id)->paginate(15);
        $allStudents = Student::all(); // For the dropdown in Add Student modal
        return view('admin.keuangan.tagihan.show', compact('tagihan', 'tagihanStudents', 'allStudents'));
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $akunOptions = $this->akunOptions;
        return view('admin.keuangan.tagihan.edit', compact('tagihan', 'akunOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'akun' => 'required|string',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'nama' => $request->nama,
            'akun' => $request->akun,
            'tanggal_jatuh_tempo' => date('Y-m-d', strtotime($request->tanggal_jatuh_tempo)),
        ]);

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Tagihan::findOrFail($id)->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus');
    }

    public function addStudent(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'jumlah' => 'required|numeric'
        ]);

        TagihanStudent::create([
            'tagihan_id' => $id,
            'student_id' => $request->student_id,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan ke tagihan.');
    }
}
