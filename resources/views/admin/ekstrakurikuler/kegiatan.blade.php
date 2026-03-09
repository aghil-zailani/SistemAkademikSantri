@extends('layouts.main')
@section('title', 'Kegiatan Ekstrakurikuler')
@section('content')

<div class="mb-6 flex justify-between items-start">
    <div>
        <p class="text-xs font-semibold text-gray-500 uppercase">Ekstrakurikuler</p>
        <h2 class="text-xl font-bold text-[#0056b3] uppercase">{{ $ekskul->nama }}</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar kegiatan dan presensi</p>
    </div>
    <button class="bg-[#0056b3] hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition">
        Tambah Kegiatan
    </button>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4 w-32">Tanggal</th>
                <th class="px-6 py-4">Ringkasan Kegiatan</th>
                <th class="px-4 py-4 text-center w-16">Hadir</th>
                <th class="px-4 py-4 text-center w-16">Sakit</th>
                <th class="px-4 py-4 text-center w-16">Izin</th>
                <th class="px-4 py-4 text-center w-16">Alpa</th>
                <th class="px-4 py-4 text-center w-24">Tanpa Ket</th>
                <th class="px-6 py-4 text-center w-28">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @forelse($ekskul->kegiatans as $kegiatan)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <i class="far fa-calendar-alt text-2xl text-[#0056b3]"></i>
                        <div>
                            <div class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('l') }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">{{ $kegiatan->ringkasan ?? '-' }}</td>
                
                <td class="px-4 py-4 text-center"><span class="bg-[#28a745] text-white px-2 py-0.5 rounded text-xs font-bold">{{ $ekskul->siswas->count() }}</span></td>
                <td class="px-4 py-4 text-center"><span class="bg-[#f59e0b] text-white px-2 py-0.5 rounded text-xs font-bold">0</span></td>
                <td class="px-4 py-4 text-center"><span class="bg-[#3b82f6] text-white px-2 py-0.5 rounded text-xs font-bold">0</span></td>
                <td class="px-4 py-4 text-center"><span class="bg-[#dc3545] text-white px-2 py-0.5 rounded text-xs font-bold">0</span></td>
                <td class="px-4 py-4 text-center"><span class="bg-gray-500 text-white px-2 py-0.5 rounded text-xs font-bold">0</span></td>
                
                <td class="px-6 py-4 text-center">
                    <button class="bg-[#28a745] text-white px-3 py-1.5 rounded text-xs hover:bg-green-600 w-full transition flex items-center justify-center gap-1">
                        <i class="fas fa-check"></i> Presensi
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-6 text-gray-500">Belum ada rekaman kegiatan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection