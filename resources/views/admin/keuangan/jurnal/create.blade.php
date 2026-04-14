@extends('layouts.main')

@section('title', 'Tambah Jurnal - Keuangan')

@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Tambah Jurnal</h2>
        <a href="{{ route('jurnal.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 text-sm rounded transition flex items-center justify-center">
            <i class="fas fa-undo"></i>
        </a>
    </div>

    {{-- Current datetime display --}}
    <div class="mx-6 mt-5 border border-gray-300 rounded-md px-4 py-3 text-sm text-gray-600 bg-gray-50">
        <div class="text-xs text-gray-400 font-medium mb-0.5">Tanggal</div>
        <div id="live-time" class="font-medium">{{ $now }}</div>
    </div>

    <form action="{{ route('jurnal.store') }}" method="POST" id="jurnal-form">
        @csrf
        <div class="px-6 pt-5 pb-4 space-y-3" id="jurnal-rows">
            @for($i = 0; $i < 6; $i++)
            <div class="grid grid-cols-12 gap-3 items-start jurnal-row">
                {{-- Nama Akun (5 cols) --}}
                <div class="col-span-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Akun</label>
                    <select name="akun[]" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 text-gray-700">
                        <option value="">-- Pilih --</option>
                        @foreach($akunOptions as $akun)
                            <option value="{{ $akun }}">{{ $akun }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Posisi (2 cols) --}}
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Posisi</label>
                    <select name="posisi[]" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 text-gray-700">
                        <option value="">-- Pilih --</option>
                        <option value="debit">Debit</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>
                {{-- Nominal (2 cols) --}}
                <div class="col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nominal</label>
                    <input type="number" name="nominal[]" min="0" placeholder="0"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                {{-- Catatan (rest) --}}
                <div class="col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Catatan</label>
                    <input type="text" name="catatan[]" placeholder="Keterangan..."
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
            @endfor
        </div>

        {{-- Add row button --}}
        <div class="px-6 pb-4">
            <button type="button" onclick="addRow()" class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1 transition">
                <i class="fas fa-plus-circle"></i> Tambah Baris
            </button>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2 rounded-b-lg">
            <a href="{{ route('jurnal.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 text-sm rounded transition font-medium">Batal</a>
            <button type="submit" class="bg-[#0056b3] hover:bg-blue-700 text-white px-4 py-2 text-sm rounded transition font-medium">Simpan</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Live clock
function updateClock() {
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    const str = now.getFullYear() + '-' +
                pad(now.getMonth()+1) + '-' +
                pad(now.getDate()) + ' ' +
                pad(now.getHours()) + ':' +
                pad(now.getMinutes()) + ':' +
                pad(now.getSeconds());
    const el = document.getElementById('live-time');
    if (el) el.textContent = str;
}
setInterval(updateClock, 1000);
updateClock();

// Add row
function addRow() {
    const container = document.getElementById('jurnal-rows');
    const firstRow = container.querySelector('.jurnal-row');
    const clone = firstRow.cloneNode(true);
    // clear values
    clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    clone.querySelectorAll('input').forEach(i => i.value = '');
    container.appendChild(clone);
}
</script>
@endpush

@endsection
