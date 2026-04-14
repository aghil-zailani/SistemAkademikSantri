@extends('layouts.main')

@section('title', 'Buku Besar - Keuangan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
    <h2 class="text-lg font-semibold text-gray-700">Buku Besar</h2>

    <form method="GET" action="{{ route('buku-besar.index') }}" class="flex items-center gap-2">
        <select name="bulan" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-1.5 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
            @foreach($bulanList as $num => $nama)
                <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>
        <select name="tahun" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-1.5 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
            @for($y = 2024; $y <= date('Y') + 1; $y++)
                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">NO</th>
                    <th class="px-6 py-4 w-28">AKSI</th>
                    <th class="px-6 py-4">AKUN</th>
                    <th class="px-6 py-4 text-right">OPEN</th>
                    <th class="px-6 py-4 text-right">DEBIT</th>
                    <th class="px-6 py-4 text-right">CREDIT</th>
                    <th class="px-6 py-4 text-right">CLOSE</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($summary as $index => $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('buku-besar.show', urlencode($row['akun'])) }}?bulan={{ $bulan }}&tahun={{ $tahun }}"
                           class="bg-[#0056b3] hover:bg-blue-700 text-white px-4 py-1.5 text-xs rounded transition font-medium">
                            Detail
                        </a>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $row['akun'] }}</td>
                    <td class="px-6 py-4 text-right">{{ number_format($row['open'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">{{ number_format($row['debit'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">{{ number_format($row['credit'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right font-semibold">{{ number_format($row['close'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 border-t border-gray-200 text-gray-700 text-sm font-semibold">
                <tr>
                    <td colspan="4" class="px-6 py-4"></td>
                    <td class="px-6 py-4 text-right">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">{{ number_format($totalCredit, 0, ',', '.') }}</td>
                    <td class="px-6 py-4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
