@extends('layouts.main')

@section('title', 'Uang Masuk - Keuangan Merchant')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Uang Masuk</h2>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">No</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Petugas</th>
                    <th class="px-6 py-4">Siswa</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($transactions as $index => $transaction)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $transactions->firstItem() + $index }}</td>
                    <td class="px-6 py-4 uppercase uppercase font-medium">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="px-6 py-4">{{ $transaction->petugas->name ?? '-' }}</td>
                    <td class="px-6 py-4 uppercase font-medium">{{ $transaction->student->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $transaction->keterangan }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages() || $transactions->total() === 0)
    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center bg-white">
        <div class="text-sm text-gray-500">
            Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ number_format($transactions->total(), 0, ',', '.') }} entries
        </div>
        <div class="flex items-center gap-2">
            <!-- Custom simple pagination layout inside wrapper if needed -->
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>
@endsection
