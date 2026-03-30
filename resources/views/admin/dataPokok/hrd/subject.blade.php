@extends('layouts.main')
@section('title', 'Daftar Mata Pelajaran')
@section('content')

<div class="bg-white rounded-t-lg shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center">
    <h2 class="text-base font-semibold text-gray-700">Daftar Mata Pelajaran</h2>
    <div class="flex gap-2">
        <a href="{{ route('hrd.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-undo text-sm"></i>
        </a>
        <button onclick="document.getElementById('tambahMapelModal').classList.remove('hidden')" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-plus text-sm"></i>
        </button>
    </div>
</div>

<div class="bg-white shadow-sm border border-t-0 border-gray-200 overflow-hidden rounded-b-lg">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#0056b3] text-white rounded flex items-center justify-center text-lg font-bold">
                {{ strtoupper(substr($hrd->name, 0, 2)) }}
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ $hrd->name }}</h3>
                <p class="text-xs text-gray-500">{{ $hrd->email }} - {{ $hrd->no_handphone ?? 'No HP tidak tersedia' }}</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500 uppercase">Total Mata Pelajaran</div>
            <div class="text-2xl font-bold text-[#0056b3]">{{ $hrd->mataPelajarans->count() }}</div>
        </div>
    </div>

    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4 w-12">No</th>
                <th class="px-6 py-4 w-24 text-center">Aksi</th>
                <th class="px-6 py-4">Nama Mata Pelajaran</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @forelse($hrd->mataPelajarans as $index => $mapel)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4 text-center">
                    <form action="{{ route('hrd.destroySubject', ['id' => $hrd->id, 'subject_id' => $mapel->id]) }}" method="POST" onsubmit="return confirm('Hapus pelajaran ini dari guru?');">
                        @csrf @method('DELETE')
                        <button class="border border-red-300 text-red-500 hover:bg-red-50 w-8 h-8 inline-flex items-center justify-center rounded bg-white transition"><i class="fas fa-trash-alt text-xs"></i></button>
                    </form>
                </td>
                <td class="px-6 py-4">{{ $mapel->nama_pelajaran }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-6 py-6 text-center text-gray-500 italic">Belum ada mata pelajaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="tambahMapelModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambahkan Mata Pelajaran</h3>
        <form action="{{ route('hrd.storeSubject', $hrd->id) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm text-gray-700 mb-2">Pilih Pelajaran</label>
                <select name="mata_pelajaran_id" required class="w-full border-gray-300 rounded border p-2 focus:ring-blue-500 text-sm">
                    <option value="" disabled selected>-- Pilih --</option>
                    @foreach($availableSubjects as $as)
                        <option value="{{ $as->id }}">{{ $as->nama_pelajaran }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('tambahMapelModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Tambahkan</button>
            </div>
        </form>
    </div>
</div>
@endsection