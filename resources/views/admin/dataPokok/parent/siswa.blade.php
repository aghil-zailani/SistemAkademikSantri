@extends('layouts.main')
@section('title', 'Data Anak/Siswa')
@section('content')

<div class="bg-white rounded-t-lg shadow-sm border border-gray-200 px-6 py-4 flex flex-col md:flex-row md:items-center justify-between">
    <h2 class="text-base font-semibold text-gray-700 mb-3 md:mb-0">Orangtua/Wali : <span class="uppercase">{{ $orangtua->nama }} - {{ $orangtua->no_handphone }}</span></h2>
    
    <div class="flex gap-2 items-center">
        <a href="{{ route('orangtua.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition" title="Kembali">
            <i class="fas fa-undo text-sm"></i>
        </a>
        <button onclick="document.getElementById('tambahSiswaModal').classList.remove('hidden')" class="bg-[#0056b3] hover:bg-blue-700 text-white px-4 py-1.5 rounded text-sm transition font-medium flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Siswa
        </button>
    </div>
</div>

<div class="bg-white shadow-sm border border-t-0 border-gray-200 overflow-hidden rounded-b-lg">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4 w-12">No</th>
                <th class="px-6 py-4 w-24 text-center">Aksi</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">NISN</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @forelse($orangtua->students as $index => $siswa)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-center">
                    <form action="{{ route('orangtua.destroySiswa', ['id' => $orangtua->id, 'student_id' => $siswa->id]) }}" method="POST" onsubmit="return confirm('Lepas tautan siswa ini dari orang tua?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="border border-gray-300 text-gray-500 hover:text-red-600 w-8 h-8 inline-flex items-center justify-center rounded bg-white transition" title="Hapus Tautan">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </td>
                <td class="px-6 py-4 font-medium uppercase">{{ $siswa->nama_lengkap }}</td>
                <td class="px-6 py-4">{{ $siswa->nisn }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Belum ada siswa yang ditautkan ke profil ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="tambahSiswaModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-lg mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tautkan Siswa</h3>
        <form action="{{ route('orangtua.storeSiswa', $orangtua->id) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm text-gray-700 mb-2">Pilih Siswa</label>
                <select name="student_id" required class="w-full border-gray-300 rounded border p-2 focus:ring-blue-500 text-sm uppercase">
                    <option value="" disabled selected>-- Cari dan Pilih Siswa --</option>
                    @foreach($availableStudents as $as)
                        <option value="{{ $as->id }}">{{ $as->nama_lengkap }} ({{ $as->nisn }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-2">*Hanya menampilkan siswa yang belum terhubung ke akun ini.</p>
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('tambahSiswaModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Tautkan</button>
            </div>
        </form>
    </div>
</div>
@endsection