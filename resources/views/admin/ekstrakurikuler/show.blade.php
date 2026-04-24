@extends('layouts.main')
@section('title', 'Detail Ekstrakurikuler')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Detail Ekstrakurikuler</h2>
    <a href="{{ route('ekstrakurikuler.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white px-4 py-1.5 rounded text-sm transition">
        Kembali
    </a>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded text-sm">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded text-sm">{{ session('error') }}</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/3">
        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Ekstrakurikuler</label>
        <div class="p-2 border border-gray-200 rounded bg-gray-50 text-gray-700 text-sm font-semibold uppercase">{{ $ekskul->nama }}</div>
    </div>
</div>

{{-- ====== TABEL MENTOR ====== --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="px-6 py-3 border-b flex justify-between items-center bg-gray-50">
        <h3 class="font-semibold text-gray-700 text-sm">Mentor</h3>
        <button onclick="document.getElementById('modalTambahMentor').classList.remove('hidden')"
                class="bg-[#0056b3] text-white px-3 py-1.5 rounded text-xs">
            Tambah Mentor Baru
        </button>
    </div>
    <table class="w-full text-sm text-left">
        <thead class="bg-white border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 w-12">No</th>
                <th class="px-6 py-3">Nama Mentor</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Semester</th>
                <th class="px-6 py-3 w-20">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekskul->mentors as $index => $mentor)
            <tr class="border-b">
                <td class="px-6 py-3">{{ $index + 1 }}</td>
                <td class="px-6 py-3">{{ $mentor->user->name ?? '-' }}</td>
                <td class="px-6 py-3">{{ $mentor->user->email ?? '-' }}</td>
                <td class="px-6 py-3">{{ $mentor->semester }}</td>
                <td class="px-6 py-3">
                    <form action="{{ route('ekstrakurikuler.hapusMentor', [$ekskul->id, $mentor->id]) }}" method="POST"
                          onsubmit="return confirm('Hapus mentor ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-[#dc3545] text-white px-2 py-1 rounded text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-400 text-xs italic">Belum ada mentor.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ====== TABEL SISWA ====== --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-col md:flex-row gap-4 items-center bg-gray-50">
        <h3 class="font-semibold text-gray-700 text-sm w-full md:w-auto md:mr-4">Daftar Siswa</h3>
        <button onclick="document.getElementById('modalTambahSiswa').classList.remove('hidden')"
                class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm whitespace-nowrap">
            Tambah Siswa
        </button>
    </div>
    <table class="w-full text-sm text-left">
        <thead class="bg-white border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 w-12">No</th>
                <th class="px-6 py-3">Nama Siswa</th>
                <th class="px-6 py-3 w-32">Kelas</th>
                <th class="px-6 py-3 w-20">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekskul->siswas as $index => $siswa)
            <tr class="border-b">
                <td class="px-6 py-3">{{ $index + 1 }}</td>
                {{-- FIX: student->nama_lengkap (bukan user->name) --}}
                <td class="px-6 py-3">{{ $siswa->student->nama_lengkap ?? '-' }}</td>
                <td class="px-6 py-3">
                    {{ $siswa->student->rombonganBelajar->nama ?? '-' }}
                </td>
                <td class="px-6 py-3">
                    <form action="{{ route('ekstrakurikuler.hapusSiswa', [$ekskul->id, $siswa->id]) }}" method="POST"
                          onsubmit="return confirm('Hapus siswa ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-[#dc3545] text-white px-2 py-1 rounded text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-400 text-xs italic">Belum ada siswa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ====== MODAL TAMBAH MENTOR ====== --}}
<div id="modalTambahMentor" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambah Mentor</h3>
        <form action="{{ route('ekstrakurikuler.tambahMentor', $ekskul->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-xs text-gray-700 mb-1">Pilih Guru / Mentor</label>
                <select name="user_id" required class="w-full border-gray-300 rounded border p-2 text-sm bg-white">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <label class="block text-xs text-gray-700 mb-1">Semester</label>
                <select name="semester" class="w-full border-gray-300 rounded border p-2 text-sm bg-white">
                    <option value="Semester Ganjil">Semester Ganjil</option>
                    <option value="Semester Genap">Semester Genap</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4">
                <button type="button" onclick="document.getElementById('modalTambahMentor').classList.add('hidden')"
                        class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ====== MODAL TAMBAH SISWA ====== --}}
<div id="modalTambahSiswa" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambah Siswa</h3>
        <form action="{{ route('ekstrakurikuler.tambahSiswa', $ekskul->id) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-xs text-gray-700 mb-1">Pilih Siswa</label>
                <select name="student_id" required class="w-full border-gray-300 rounded border p-2 text-sm bg-white">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4">
                <button type="button" onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')"
                        class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection