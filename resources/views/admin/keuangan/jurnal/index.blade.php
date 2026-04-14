@extends('layouts.main')

@section('title', 'Jurnal Umum - Keuangan')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
    {{ session('success') }}
</div>
@endif

{{-- Top bar --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
    <h2 class="text-lg font-semibold text-gray-700">Jurnal Umum</h2>
    <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('jurnal.index') }}" class="flex items-center gap-2">
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
        <a href="{{ route('jurnal.create') }}" class="bg-[#0056b3] hover:bg-blue-700 text-white px-3 py-1.5 text-sm rounded transition font-medium flex items-center gap-1">
            <i class="fas fa-plus"></i>
        </a>
    </div>
</div>

{{-- Journal entries --}}
<div class="space-y-0">
    @forelse($jurnals as $jurnal)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-4">
        {{-- Journal header row --}}
        <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center gap-3 text-sm font-semibold text-blue-700">
                <i class="far fa-calendar"></i>
                <span>{{ $jurnal->tanggal->format('Y-m-d H:i:s') }}</span>
                <i class="fas fa-user text-gray-500"></i>
                <span class="text-gray-700">{{ $jurnal->user->name ?? 'Administrator' }}</span>
            </div>
            <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 text-xs transition">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>

        {{-- Line items --}}
        <table class="w-full text-sm">
            <thead class="text-gray-400 uppercase text-xs border-b border-gray-100">
                <tr>
                    <th class="px-5 py-2 text-left font-medium w-2/5">ACCOUNT</th>
                    <th class="px-5 py-2 text-right font-medium w-32">DEBIT</th>
                    <th class="px-5 py-2 text-right font-medium w-32">CREDIT</th>
                    <th class="px-5 py-2 text-left font-medium">NOTE</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($jurnal->items as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-2.5 text-gray-800">{{ $item->akun }}</td>
                    <td class="px-5 py-2.5 text-right">
                        @if($item->posisi === 'debit')
                            {{ number_format($item->nominal, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-2.5 text-right">
                        @if($item->posisi === 'credit')
                            {{ number_format($item->nominal, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-2.5 text-gray-600 text-xs">{{ $item->catatan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-10 text-center text-gray-500 text-sm">
        Tidak ada jurnal pada periode ini.
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($jurnals->hasPages())
<div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center mt-4">
    <div class="text-sm text-gray-500">
        Showing {{ $jurnals->firstItem() }} to {{ $jurnals->lastItem() }} of {{ $jurnals->total() }} entries
    </div>
    <div>{{ $jurnals->appends(request()->query())->links('pagination::tailwind') }}</div>
</div>
@endif

@endsection
