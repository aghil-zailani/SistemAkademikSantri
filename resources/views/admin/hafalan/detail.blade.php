@extends('layouts.main')
@section('title', 'Detail Hafalan Surah')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Detail Hafalan Surah</h2>
    <a href="{{ route('hafalan.show', $student->id) }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white px-4 py-1.5 rounded text-sm transition">
        Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-6">
    <h3 class="font-bold text-gray-800 text-base mb-2">{{ $surah->nomor_surah }}. {{ $surah->nama_arab }} ({{ $surah->nama_surah }})</h3>
    <div class="text-sm text-gray-600 space-y-1 mt-3">
        <p>Siswa: <span class="font-bold text-gray-800">{{ $student->name }}</span></p>
        <p>Status: <span class="bg-[#3b82f6] text-white text-[11px] px-2 py-0.5 rounded font-medium">{{ $hafalan->status ?? 'Belum' }}</span></p>
        <p>Total Ayat: <span class="font-bold">{{ $surah->total_ayat }}</span></p>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="font-semibold text-gray-700">Riwayat Setoran Hafalan</h3>
    </div>
    
    <div class="p-6 space-y-4">
        @if($hafalan && $hafalan->setorans->count() > 0)
            @foreach($hafalan->setorans as $index => $setoran)
                <div class="border border-blue-200 rounded-md overflow-hidden bg-white">
                    <div class="p-4 relative">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-[#0056b3] text-white text-xs px-2 py-1 rounded font-semibold">
                                Setoran #{{ $hafalan->setorans->count() - $index }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $setoran->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        <div class="text-sm text-gray-700 mt-3 space-y-1">
                            <p>Rentang Ayat: <span class="font-semibold">{{ $setoran->ayat_mulai }} - {{ $setoran->ayat_selesai }}</span></p>
                            <p>Nilai: <span class="font-semibold">{{ $setoran->nilai ?? '-' }}</span></p>
                            <p>Catatan</p>
                            <div class="bg-gray-50 border border-gray-200 p-2 rounded text-gray-600 mt-1 min-h-[40px]">
                                {{ $setoran->catatan ?? '-' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-2 border-t border-blue-200 flex justify-end">
                        <button class="bg-[#dc3545] text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center text-gray-500 py-4 text-sm">Belum ada riwayat setoran untuk surah ini.</p>
        @endif
    </div>
</div>

@endsection