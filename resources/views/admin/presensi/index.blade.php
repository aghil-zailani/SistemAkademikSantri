@extends('layouts.main')
@section('title', 'Data Presensi Siswa')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Presensi</h2>
        
        <div class="flex items-center space-x-2 mt-4 md:mt-0">
            <form action="{{ route('presensi.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm">
                
                <select name="rombongan_belajar_id" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($rombels as $r)
                        <option value="{{ $r->id }}" {{ $rombel_id == $r->id ? 'selected' : '' }}>{{ $r->nama }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('presensi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition shadow-sm text-sm">
                <i class="fas fa-edit mr-1"></i> Input Presensi
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-semibold text-gray-500 uppercase">
                    <th class="py-3 px-4">TANGGAL</th>
                    <th class="py-3 px-4">NAMA SISWA</th>
                    <th class="py-3 px-4">KELAS</th>
                    <th class="py-3 px-4">MAPEL</th>
                    <th class="py-3 px-4">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presensis as $p)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $p->student->nama_lengkap ?? '-' }}</td>
                    <td class="py-3 px-4 text-sm">{{ $p->rombonganBelajar->nama ?? '-' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $p->mataPelajaran->nama_mata_pelajaran ?? 'Harian (Umum)' }}</td>
                    <td class="py-3 px-4">
                        @php
                            $color = match($p->status) {
                                'Hadir' => 'bg-green-100 text-green-700',
                                'Sakit' => 'bg-yellow-100 text-yellow-700',
                                'Izin' => 'bg-blue-100 text-blue-700',
                                'Alpa' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $color }}">{{ $p->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-sm text-gray-500">Belum ada data presensi di tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $presensis->links() }}</div>
</div>
@endsection