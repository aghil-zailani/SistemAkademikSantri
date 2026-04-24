@extends('layouts.main')
@section('title', 'Daftar Pembayaran: ' . $tagihan->nama)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Pembayaran : {{ $tagihan->nama }}</h2>
        <a href="{{ route('admin.tagihan.index') }}" class="bg-amber-500 hover:bg-amber-600 text-white p-2 rounded-md transition shadow-sm w-8 h-8 flex items-center justify-center">
            <i class="fas fa-undo"></i>
        </a>
    </div>

    <div class="flex flex-wrap gap-2 mb-6">
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm flex items-center shadow-sm transition">
            <i class="fas fa-money-bill-wave mr-2"></i> Tagih Pembayaran
        </button>
        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm flex items-center shadow-sm transition">
            <i class="fas fa-plus mr-2"></i> Tambah Siswa
        </button>
        <button class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded text-sm flex items-center shadow-sm transition">
            <i class="fas fa-edit mr-2"></i> Ubah Nominal
        </button>
        <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded text-sm flex items-center shadow-sm transition">
            <i class="fas fa-download mr-2"></i> Download Xls
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-semibold text-gray-500 uppercase">
                    <th class="py-3 px-4 w-12">NO</th>
                    <th class="py-3 px-4">NAMA</th>
                    <th class="py-3 px-4 text-right">JUMLAH</th>
                    <th class="py-3 px-4 text-center">STATUS</th>
                    <th class="py-3 px-4">TANGGAL BAYAR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan->tagihanSiswas as $index => $detail)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800 uppercase">{{ $detail->student->name ?? 'Unknown Student' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800 text-right">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-sm text-center">
                        @if($detail->status == 'success')
                            <span class="text-gray-800">{{ $detail->status }}</span>
                        @else
                            <span class="text-gray-500">{{ $detail->status }}</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        {{ $detail->tanggal_bayar ? \Carbon\Carbon::parse($detail->tanggal_bayar)->format('Y-m-d H:i:s') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-sm text-gray-500">Belum ada siswa yang ditambahkan ke tagihan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection