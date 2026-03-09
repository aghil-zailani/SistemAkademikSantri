@extends('layouts.main')
@section('title', 'Rekam Medis Siswa')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Rekam Medis Siswa</h2>
    <div class="flex gap-2">
        <button class="bg-gray-500 hover:bg-gray-600 text-white w-8 h-8 rounded flex items-center justify-center transition" title="Laporan Harian">
            <i class="fas fa-copy text-sm"></i>
        </button>
        <a href="{{ route('kesehatan.create') }}" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition" title="Tambah Rekam Medis">
            <i class="fas fa-plus text-sm"></i>
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-12">No</th>
                    <th class="px-6 py-4 w-40">Aksi</th>
                    <th class="px-6 py-4 w-1/4">Nama</th>
                    <th class="px-6 py-4 w-1/3">Masuk</th>
                    <th class="px-6 py-4">Keluar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($rekamMedis as $index => $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1.5">
                            <a href="{{ route('kesehatan.edit', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-blue-600 hover:border-blue-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Edit Data Masuk">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            
                            <a href="{{ route('kesehatan.keluar', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-green-600 hover:border-green-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Proses Keluar Klinik">
                                <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                            </a>

                            <form action="{{ route('kesehatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border border-gray-300 text-gray-500 hover:text-red-600 hover:border-red-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Hapus Data">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium uppercase">{{ $item->siswa->name ?? 'Anonim' }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('Y-m-d') }}</div>
                        <div class="text-gray-800">{{ $item->keluhan_masuk }}</div>
                        <div class="text-gray-500 text-xs mt-1">Petugas : {{ $item->petugasMasuk->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->tanggal_keluar)
                            <div class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('Y-m-d') }}</div>
                            <div class="text-gray-800">{{ $item->keterangan_keluar }}</div>
                            <div class="text-gray-500 text-xs mt-1">Petugas : {{ $item->petugasKeluar->name ?? '-' }}</div>
                        @else
                            <span class="text-yellow-600 bg-yellow-50 px-2 py-1 rounded text-xs font-medium border border-yellow-200">Sedang Dirawat</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection