@extends('layouts.main')
@section('title', 'Keterangan Keluar Klinik')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Tambah Keterangan Keluar Klinik</h2>
    <a href="{{ route('kesehatan.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-undo text-sm"></i>
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
        <h3 class="font-semibold text-gray-700 text-sm">Informasi Pasien</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm text-gray-700">
        <div>
            <span class="block text-gray-500 text-xs mb-1 uppercase tracking-wider">Nama</span>
            <span class="font-semibold uppercase">{{ $rekam->siswa->name }}</span>
        </div>
        <div>
            <span class="block text-gray-500 text-xs mb-1 uppercase tracking-wider">Tanggal Masuk Klinik</span>
            <span>{{ $rekam->tanggal_masuk }}</span>
        </div>
        <div>
            <span class="block text-gray-500 text-xs mb-1 uppercase tracking-wider">Catatan</span>
            <span>{{ $rekam->keluhan_masuk }}</span>
        </div>
        <div>
            <span class="block text-gray-500 text-xs mb-1 uppercase tracking-wider">Petugas</span>
            <span>{{ $rekam->petugasMasuk->name }}</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="border-b border-gray-200 pb-3 mb-4">
        <h3 class="font-semibold text-gray-700 text-sm">Keterangan Keluar Klinik</h3>
    </div>
    
    <form action="{{ route('kesehatan.updateKeluar', $rekam->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-4 mb-6">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal_keluar" value="{{ date('Y-m-d') }}" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan_keluar" rows="3" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm">Sembuh</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('kesehatan.index') }}" class="px-4 py-2 bg-[#f59e0b] text-white rounded-md text-sm font-medium hover:bg-yellow-600 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#0056b3] text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection