@extends('layouts.main')
@section('title', 'Detail Siswa')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Detail Siswa - <span class="uppercase">{{ $siswa->nama_lengkap }}</span></h2>
        <div class="flex gap-2">
            <a href="{{ route('siswa.show', $siswa->id) }}" class="border border-blue-300 px-4 py-1.5 rounded text-sm text-blue-600 hover:bg-blue-50 flex items-center gap-2"><i class="fas fa-eye"></i> Detail</a>
            <a href="{{ route('siswa.index') }}" class="border border-gray-300 px-4 py-1.5 rounded text-sm text-gray-600 hover:bg-gray-50 flex items-center gap-2"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="md:col-span-3 grid grid-cols-2 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <div class="font-bold text-gray-800 uppercase">{{ $siswa->nama_lengkap }}</div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NISN</label>
                    <span class="bg-[#0056b3] text-white px-2 py-0.5 rounded text-sm font-bold">{{ $siswa->nisn }}</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NIS</label>
                    <div class="text-gray-800">{{ $siswa->nis ?? '-' }}</div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</label>
                    <div class="text-gray-800">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ID Kartu</label>
                    @if($siswa->id_kartu)
                        <span class="bg-[#28a745] text-white px-2 py-0.5 rounded text-sm"><i class="fas fa-check"></i> Kartu terdaftar</span>
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </div>
                <div class="col-span-2 md:col-span-3 mt-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Sekolah</label>
                    <div class="font-bold text-gray-800">{{ $siswa->sekolah }}</div>
                </div>
            </div>
            
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded border border-gray-200 flex items-center justify-center text-gray-400 text-3xl font-light mb-2 bg-gray-50">
                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 2)) }}
                </div>
                <div class="text-center">
                    <div class="font-bold text-gray-800 uppercase text-sm">{{ $siswa->nama_lengkap }}</div>
                    <div class="text-xs text-gray-500 uppercase">{{ $siswa->nama_lengkap }} ({{ $siswa->nisn }})</div>
                </div>
                <div class="w-full border border-gray-200 rounded p-4 mt-4 text-center">
                    <div class="text-2xl font-bold text-gray-800">477</div>
                    <div class="text-xs text-gray-500">Total Presensi</div>
                </div>
            </div>
        </div>

        <hr class="mb-6 border-gray-200">

        <h3 class="text-sm font-bold text-gray-700 mb-4">Informasi Akun Login</h3>
        <div class="bg-blue-50/50 border border-blue-100 rounded p-4 mb-8 flex items-center text-sm">
            @if($siswa->user_id)
                <span class="font-bold text-gray-800 mr-2">Memiliki Akun Login</span> Siswa ini sudah memiliki akun untuk login ke sistem.
            @else
                <span class="font-bold text-gray-800 mr-2">Belum Memiliki Akun Login</span> Siswa ini belum memiliki akun untuk login ke sistem. <a href="#" class="text-blue-600 font-medium hover:underline ml-1">Klik di sini untuk membuat akun.</a>
            @endif
        </div>

        <h3 class="text-sm font-bold text-gray-700 mb-4">Aktivitas Presensi Terbaru</h3>
        <table class="w-full text-sm text-left mb-4">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs">
                <tr>
                    <th class="px-4 py-3">TANGGAL & WAKTU</th>
                    <th class="px-4 py-3">MESIN</th>
                    <th class="px-4 py-3">STATUS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($presensis as $p)
                <tr>
                    <td class="px-4 py-3">
                        <div class="text-gray-800">{{ $p['tanggal']->format('d/m/Y H:i:s') }}</div>
                        <div class="text-xs text-gray-500">{{ $p['tanggal']->diffForHumans() }}</div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $p['mesin'] }}</td>
                    <td class="px-4 py-3"><span class="bg-[#28a745] text-white px-2 py-0.5 rounded text-xs">{{ $p['status'] }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            <button class="border border-blue-300 text-blue-600 px-4 py-1.5 rounded text-sm hover:bg-blue-50 transition">Lihat Semua Aktivitas</button>
        </div>

    </div>
    
    <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 rounded-b-lg flex justify-between items-center text-sm">
        <div class="text-gray-500">Siswa terdaftar pada {{ $siswa->created_at->format('d F Y H:i') }}</div>
        <div class="flex gap-2">
            <a href="{{ route('siswa.edit', $siswa->id) }}" class="bg-[#0056b3] text-white px-4 py-2 rounded font-medium hover:bg-blue-700 transition flex items-center gap-2"><i class="fas fa-edit"></i> Edit Siswa</a>
            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?');">
                @csrf @method('DELETE')
                <button type="submit" class="border border-red-300 text-red-600 px-4 py-2 rounded font-medium hover:bg-red-50 transition flex items-center gap-2"><i class="fas fa-trash"></i> Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection