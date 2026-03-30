<?php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangTua;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrangTuaController extends Controller
{
    public function index()
    {
        // Load data orang tua beserta anak-anaknya
        $orangtuas = OrangTua::with('students')->latest()->get();
        return view('admin.dataPokok.parent.index', compact('orangtuas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_handphone' => 'nullable|string|max:20',
        ]);

        OrangTua::create($request->all());
        return back()->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $orangtua = OrangTua::findOrFail($id);
        return view('admin.dataPokok.parent.edit', compact('orangtua'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string', 'no_handphone' => 'nullable|string']);
        
        OrangTua::findOrFail($id)->update($request->all());
        return redirect()->route('orangtua.index')->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        OrangTua::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }

    // --- MANAJEMEN ANAK/SISWA ---
    public function manageSiswa($id)
    {
        $orangtua = OrangTua::with('students')->findOrFail($id);
        
        // Ambil daftar siswa yang BELUM ditautkan ke orang tua ini (untuk dropdown pilihan)
        $linkedStudentIds = $orangtua->students->pluck('id')->toArray();
        $availableStudents = Student::whereNotIn('id', $linkedStudentIds)->get();

        return view('admin.dataPokok.parent.siswa', compact('orangtua', 'availableStudents'));
    }

    public function storeSiswa(Request $request, $id)
    {
        $request->validate(['student_id' => 'required|exists:students,id']);
        
        $orangtua = OrangTua::findOrFail($id);
        $orangtua->students()->attach($request->student_id);

        return back()->with('success', 'Siswa berhasil ditautkan.');
    }

    public function destroySiswa($id, $student_id)
    {
        $orangtua = OrangTua::findOrFail($id);
        $orangtua->students()->detach($student_id);

        return back()->with('success', 'Tautan siswa dilepas.');
    }

    // --- RESET PASSWORD ---
    public function resetPassword($id)
    {
        $orangtua = OrangTua::findOrFail($id);
        
        // Buat akun user jika belum ada
        if (!$orangtua->user_id) {
            $user = User::create([
                'name' => $orangtua->nama,
                'email' => strtolower(str_replace(' ', '', $orangtua->nama)) . rand(10,99) . '@parent.com',
                'password' => Hash::make('password123'),
                'role' => 'parent',
            ]);
            $orangtua->update(['user_id' => $user->id]);
            return back()->with('success', 'Akun login berhasil dibuat. Password default: password123');
        }

        // Generate password baru jika sudah punya akun
        $newPassword = Str::random(8);
        $user = User::findOrFail($orangtua->user_id);
        $user->update(['password' => Hash::make($newPassword)]);

        return back()->with('success', "Password baru berhasil di-generate: <b>{$newPassword}</b>");
    }
}