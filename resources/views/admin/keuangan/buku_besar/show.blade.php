@extends('layouts.main')

@section('title', 'Detail Buku Besar - Keuangan')

@section('content')
{{-- Header --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
    <h2 class="text-lg font-semibold text-gray-700">Detail : {{ $akunDecoded }}</h2>
    <div class="flex items-center gap-2">
        <button class="bg-[#22c55e] hover:bg-green-600 text-white px-3 py-2 text-sm rounded transition flex items-center justify-center" title="Download">
            <i class="fas fa-download"></i>
        </button>
        <a href="{{ route('buku-besar.index') }}?bulan={{ $bulan }}&tahun={{ $tahun }}"
           class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 text-sm rounded transition flex items-center justify-center" title="Kembali">
            <i class="fas fa-undo"></i>
        </a>
    </div>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-0 bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden text-center">
    <div class="px-6 py-5 border-r border-gray-200">
        <div class="text-xs text-gray-500 uppercase font-medium mb-1">OPEN</div>
        <div class="text-base font-semibold text-gray-800">{{ number_format($open, 0, ',', '.') }}</div>
    </div>
    <div class="px-6 py-5 border-r border-gray-200">
        <div class="text-xs text-gray-500 uppercase font-medium mb-1">DEBIT</div>
        <div class="text-base font-semibold text-green-600">{{ number_format($debit, 0, ',', '.') }}</div>
    </div>
    <div class="px-6 py-5 border-r border-gray-200">
        <div class="text-xs text-gray-500 uppercase font-medium mb-1">CREDIT</div>
        <div class="text-base font-semibold {{ $credit > 0 ? 'text-red-500' : 'text-gray-800' }}">{{ number_format($credit, 0, ',', '.') }}</div>
    </div>
    <div class="px-6 py-5">
        <div class="text-xs text-gray-500 uppercase font-medium mb-1">CLOSE</div>
        <div class="text-base font-bold text-gray-900">{{ number_format($close, 0, ',', '.') }}</div>
    </div>
</div>

{{-- Transaction Table --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-5 py-4 w-14">NO</th>
                    <th class="px-5 py-4">TANGGAL</th>
                    <th class="px-5 py-4">KETERANGAN</th>
                    <th class="px-5 py-4 text-right">OPEN</th>
                    <th class="px-5 py-4 text-right">DEBIT</th>
                    <th class="px-5 py-4 text-right">CREDIT</th>
                    <th class="px-5 py-4 text-right">CLOSE</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($rows as $index => $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">{{ $rows->firstItem() + $index }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $row->tanggal->format('Y-m-d H:i:s') }}</td>
                    <td class="px-5 py-3">{{ $row->keterangan }}</td>
                    <td class="px-5 py-3 text-right">{{ number_format($row->open, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right">{{ number_format($row->debit, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right">{{ number_format($row->credit, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right font-medium">{{ number_format($row->close, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-6 text-center text-gray-500">
                        Tidak ada transaksi pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center bg-white">
        <div class="text-sm text-gray-500">
            Showing {{ $rows->firstItem() ?? 0 }} to {{ $rows->lastItem() ?? 0 }} of {{ number_format($rows->total(), 0, ',', '.') }} entries
        </div>
        <div class="flex items-center gap-1 text-sm">
            @if($rows->onFirstPage())
                <span class="px-3 py-1.5 border border-gray-200 text-gray-400 rounded cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $rows->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 text-gray-700 rounded hover:bg-gray-50 transition">Previous</a>
            @endif

            @foreach($rows->getUrlRange(1, $rows->lastPage()) as $page => $url)
                @if($page == $rows->currentPage())
                    <span class="px-3 py-1.5 bg-[#0056b3] text-white rounded font-medium">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 text-gray-700 rounded hover:bg-gray-50 transition">{{ $page }}</a>
                @endif
            @endforeach

            @if($rows->hasMorePages())
                <a href="{{ $rows->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 text-gray-700 rounded hover:bg-gray-50 transition">Next</a>
            @else
                <span class="px-3 py-1.5 border border-gray-200 text-gray-400 rounded cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>
</div>
@endsection
