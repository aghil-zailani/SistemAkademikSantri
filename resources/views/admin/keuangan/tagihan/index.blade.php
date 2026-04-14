@extends('layouts.main')

@section('title', 'Tagihan - Keuangan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Tagihan</h2>
    <a href="{{ route('tagihan.create') }}" class="bg-[#0056b3] hover:bg-blue-700 text-white px-4 py-2 text-sm rounded transition font-medium flex items-center gap-2">
        <i class="fas fa-plus"></i>
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">NO</th>
                    <th class="px-6 py-4 w-1/3">NAMA</th>
                    <th class="px-6 py-4">AKUN</th>
                    <th class="px-6 py-4">SUDAH BAYAR</th>
                    <th class="px-6 py-4">BELUM BAYAR</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($tagihans as $index => $tagihan)
                @php
                    $sudahBayarNominal = $tagihan->students->where('status', 'success')->sum('jumlah');
                    $sudahBayarCount = $tagihan->students->where('status', 'success')->count();
                    $belumBayarNominal = $tagihan->students->where('status', 'pending')->sum('jumlah');
                    $belumBayarCount = $tagihan->students->where('status', 'pending')->count();
                @endphp
                <tr class="hover:bg-gray-50 align-top">
                    <td class="px-6 py-4">{{ $tagihans->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800 mb-1">{{ $tagihan->nama }}</div>
                        <div class="flex items-center gap-1 mt-2">
                            <a href="{{ route('tagihan.show', $tagihan->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 text-xs rounded transition font-medium">Detail</a>
                            <a href="{{ route('tagihan.edit', $tagihan->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 text-xs rounded transition font-medium">Ubah</a>
                            <form action="{{ route('tagihan.destroy', $tagihan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-400 hover:bg-red-500 text-white px-2 py-1 text-xs rounded transition font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $tagihan->akun }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ number_format($sudahBayarNominal, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $sudahBayarCount }} santri</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ number_format($belumBayarNominal, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $belumBayarCount }} santri</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data tagihan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tagihans->hasPages() || $tagihans->total() === 0)
    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center bg-white">
        <div class="text-sm text-gray-500">
            Showing {{ $tagihans->firstItem() ?? 0 }} to {{ $tagihans->lastItem() ?? 0 }} of {{ number_format($tagihans->total(), 0, ',', '.') }} entries
        </div>
        <div class="flex items-center gap-2">
            {{ $tagihans->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>
@endsection
