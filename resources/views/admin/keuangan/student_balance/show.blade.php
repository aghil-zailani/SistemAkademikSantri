@extends('layouts.main')

@section('title', 'Detail Saldo Siswa - Keuangan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
    <!-- Header -->
    <div class="px-6 py-4 flex justify-between items-center border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">Detail Saldo Siswa</h2>
        <a href="{{ route('uang-siswa.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-undo text-sm"></i>
        </a>
    </div>

    <!-- Info Student -->
    <div class="px-6 py-6 border-b border-gray-200 bg-white grid grid-cols-1 md:grid-cols-4 gap-4 text-sm text-gray-700">
        <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-1">Nama</div>
            <div class="font-medium uppercase">{{ $balance->student->nama_lengkap ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-1">NISN</div>
            <div class="font-medium">{{ $balance->student->nisn ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-1">Tanggal Lahir</div>
            <div class="font-medium">{{ $balance->student->tanggal_lahir ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-1">Saldo Terkini</div>
            <div class="font-medium">{{ number_format($balance->saldo, 0, ',', '.') }}</div>
            <div class="text-xs mt-1 text-gray-500">{{ $balance->updated_at->format('Y-m-d H:i:s') }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">No</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 w-1/3">Note</th>
                    <th class="px-6 py-4 text-center">Open</th>
                    <th class="px-6 py-4 text-center">Debit</th>
                    <th class="px-6 py-4 text-center">Credit</th>
                    <th class="px-6 py-4 text-center">Close</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($transactions as $index => $tx)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $transactions->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-medium">{{ $tx->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="px-6 py-4">{{ $tx->note }}</td>
                    <td class="px-6 py-4 text-center font-medium">{{ number_format($tx->open, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center font-medium">{{ number_format($tx->debit, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center font-medium">{{ number_format($tx->credit, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center font-medium">{{ number_format($tx->close, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada riwayat transaksi detail.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages() || $transactions->total() === 0)
    <div class="px-6 py-4 flex justify-between items-center border-t border-gray-200 bg-white">
        <div class="text-sm text-gray-500">
            Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ number_format($transactions->total(), 0, ',', '.') }} entries
        </div>
        <div class="flex items-center gap-2">
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>
@endsection
