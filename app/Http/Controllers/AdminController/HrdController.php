<?php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Hash;

class HrdController extends Controller
{
    public function index()
    {
        // Menampilkan staff (admin & teacher) beserta relasi mapel
        $hrds = User::with('mataPelajarans')
                ->whereIn('role', ['admin', 'teacher', 'staff'])
                ->get();
        return view('admin.dataPokok.hrd.index', compact('hrds'));
    }

    public function create()
    {
        return view('admin.dataPokok.hrd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,teacher',
        ]);

        User::create([
            'name' => $request->name,
            'no_handphone' => $request->no_handphone,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('hrd.index')->with('success', 'HRD berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hrd = User::findOrFail($id);
        return view('admin.dataPokok.hrd.edit', compact('hrd'));
    }

    public function update(Request $request, $id)
    {
        $hrd = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$hrd->id,
            'role' => 'required|in:admin,teacher',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'no_handphone' => $request->no_handphone,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $hrd->update($data);
        return redirect()->route('admin.dataPokok.hrd.index')->with('success', 'Data HRD berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Data HRD dihapus.');
    }

    // --- MANAJEMEN MATA PELAJARAN ---
    public function subjects($id)
    {
        $hrd = User::with('mataPelajarans')->findOrFail($id);
        // Ambil mapel yang belum ditautkan ke guru ini
        $linkedIds = $hrd->mataPelajarans->pluck('id')->toArray();
        $availableSubjects = MataPelajaran::whereNotIn('id', $linkedIds)->get();

        return view('admin.dataPokok.hrd.subject', compact('hrd', 'availableSubjects'));
    }

    public function storeSubject(Request $request, $id)
    {
        $request->validate(['mata_pelajaran_id' => 'required']);
        $hrd = User::findOrFail($id);
        $hrd->mataPelajarans()->attach($request->mata_pelajaran_id);
        
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function destroySubject($id, $subject_id)
    {
        $hrd = User::findOrFail($id);
        $hrd->mataPelajarans()->detach($subject_id);
        
        return back()->with('success', 'Mata Pelajaran dilepas dari guru ini.');
    }

    // --- MANAJEMEN FINGERPRINT ---
    public function fingerprint()
    {
        $hrds = User::whereIn('role', ['admin', 'teacher', 'staff'])->get();
        return view('admin.dataPokok.hrd.fingerprint', compact('hrds'));
    }

    public function updateFingerprint(Request $request)
    {
        // Menyimpan update massal (Bulk Update)
        foreach ($request->fingerprints as $id => $data) {
            User::where('id', $id)->update([
                'mesin_fingerprint' => $data['mesin'],
                'fingerprint_id' => $data['id']
            ]);
        }
        return back()->with('success', 'Data Fingerprint berhasil disimpan.');
    }
}