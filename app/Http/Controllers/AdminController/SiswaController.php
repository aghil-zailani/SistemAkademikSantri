<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
        
        // Data untuk Summary Cards
        $total = $students->count();
        $punyaKartu = $students->whereNotNull('id_kartu')->count();
        $tanpaKartu = $students->whereNull('id_kartu')->count();
        $punyaUser = $students->whereNotNull('user_id')->count();

        return view('admin.dataPokok.student.index', compact('students', 'total', 'punyaKartu', 'tanpaKartu', 'punyaUser'));
    }

    public function create()
    {
        return view('admin.dataPokok.student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|unique:students,nisn',
            'email_user' => 'nullable|email|unique:users,email',
        ]);

        $userId = null;

        // Logika pembuatan User otomatis jika form User Login diisi
        if ($request->filled('nama_user') || $request->filled('email_user')) {
            $user = User::create([
                'name' => $request->nama_user ?? $request->nama_lengkap,
                'email' => $request->email_user ?? strtolower(str_replace(' ', '', $request->nama_lengkap)) . '@student.com',
                'password' => Hash::make('password123'), // Default password
                'role' => 'student',
            ]);
            $userId = $user->id;
        }

        Student::create([
            'user_id' => $userId,
            'nama_lengkap' => $request->nama_lengkap,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'id_kartu' => $request->id_kartu,
            'va_number' => '250' . rand(100, 999), // Contoh generate VA auto
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $siswa = Student::with('user')->findOrFail($id);
        
        // Dummy data aktivitas presensi untuk kebutuhan UI
        $presensis = [
            ['tanggal' => Carbon::now()->subHours(2), 'mesin' => 'PIAT12-01', 'status' => 'Siang'],
            ['tanggal' => Carbon::now()->subDays(1), 'mesin' => 'PIAT12-01', 'status' => 'Siang'],
            ['tanggal' => Carbon::now()->subDays(2), 'mesin' => 'PIAT12-01', 'status' => 'Siang'],
        ];

        return view('admin.dataPokok.student.show', compact('siswa', 'presensis'));
    }

    public function edit($id)
    {
        $siswa = Student::with('user')->findOrFail($id);
        return view('admin.dataPokok.student.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Student::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|unique:students,nisn,' . $siswa->id,
        ]);

        $siswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'id_kartu' => $request->id_kartu,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}