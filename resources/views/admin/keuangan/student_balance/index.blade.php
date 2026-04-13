@extends('layouts.main')

@section('title', 'Uang Siswa - Keuangan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Data Saldo Siswa</h2>
    <div class="text-sm font-medium text-gray-700">Total {{ number_format($totalBalance, 0, ',', '.') }}</div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">No</th>
                    <th class="px-6 py-4 w-24">#</th>
                    <th class="px-6 py-4">Siswa</th>
                    <th class="px-6 py-4 text-center">Saldo</th>
                    <th class="px-6 py-4 text-right">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($balances as $index => $balance)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $balances->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('uang-siswa.show', $balance->student_id) }}" class="bg-[#0056b3] hover:bg-blue-700 text-white px-3 py-1.5 text-xs rounded transition font-medium">Detail</a>
                    </td>
                    <td class="px-6 py-4 uppercase font-medium">{{ $balance->student->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ number_format($balance->saldo, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right uppercase font-medium">{{ $balance->updated_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data saldo siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($balances->hasPages() || $balances->total() === 0)
    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center bg-white">
        <div class="text-sm text-gray-500">
            Showing {{ $balances->firstItem() ?? 0 }} to {{ $balances->lastItem() ?? 0 }} of {{ number_format($balances->total(), 0, ',', '.') }} entries
        </div>
        <div class="flex items-center gap-2">
            {{ $balances->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>
@endsection
