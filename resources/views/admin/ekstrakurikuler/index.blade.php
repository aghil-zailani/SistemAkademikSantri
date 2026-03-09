@extends('layouts.main')
@section('title', 'Ekstrakurikuler')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Ekstrakurikuler</h2>
    <button onclick="document.getElementById('tambahModal').classList.remove('hidden')" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-plus text-sm"></i>
    </button>
</div>

<div class="space-y-4">
    @foreach($ekskuls as $ekskul)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
        <h3 class="font-bold text-gray-800 uppercase mb-3">{{ $ekskul->nama }}</h3>
        
        <div class="text-sm text-gray-600 mb-2">
            <span class="block text-xs font-semibold text-gray-400 mb-1">Mentor</span>
            <div class="flex flex-wrap gap-2">
                @forelse($ekskul->mentors as $mentor)
                    <span class="bg-[#0056b3] text-white px-2 py-1 rounded text-xs">{{ $mentor->user->name ?? 'Anonim' }}</span>
                @empty
                    <span class="text-gray-400 text-xs italic">- Belum ada mentor -</span>
                @endforelse
            </div>
        </div>

        <div class="text-sm text-gray-600 mb-4 border-b border-gray-100 pb-4">
            <span class="block text-xs font-semibold text-gray-400 mb-1">Siswa</span>
            <span>{{ $ekskul->siswas->count() }} siswa</span>
        </div>

        <div class="flex justify-end gap-2">
            <button class="bg-[#f59e0b] text-white px-4 py-1.5 rounded text-xs hover:bg-yellow-600 transition">Penilaian</button>
            <a href="{{ route('ekstrakurikuler.show', $ekskul->id) }}" class="bg-[#3b82f6] text-white px-4 py-1.5 rounded text-xs hover:bg-blue-600 transition">Detail</a>
            <a href="{{ route('ekstrakurikuler.kegiatan', $ekskul->id) }}" class="bg-[#28a745] text-white px-4 py-1.5 rounded text-xs hover:bg-green-600 transition">Kegiatan</a>
        </div>
    </div>
    @endforeach
</div>

<div id="tambahModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-lg mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambah Ekstrakurikuler</h3>
        <form action="{{ route('ekstrakurikuler.store') }}" method="POST">
            @csrf
            <label class="block text-sm text-gray-700 mb-2">Nama Ekstrakurikuler</label>
            <input type="text" name="nama" required class="w-full border-gray-300 rounded border p-2 mb-4 focus:ring-blue-500">
            <div class="flex gap-2">
                <button type="submit" class="bg-[#28a745] text-white px-4 py-2 rounded text-sm hover:bg-green-600">Simpan</button>
                <button type="button" onclick="document.getElementById('tambahModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded text-sm hover:bg-gray-600">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection