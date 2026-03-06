@extends('layouts.main')
@section('title', 'Hafalan - ' . $student->name)
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Hafalan Al Qur'an</h2>
    <div class="flex gap-2">
        <a href="{{ route('hafalan.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center">
            <i class="fas fa-undo text-sm"></i>
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 font-semibold text-gray-700 uppercase">
    {{ $student->name }}
</div>

<div class="space-y-4">
    @foreach($surahs as $surah)
        @php
            $hafalan = $hafalans->get($surah->id);
            $terakhir = $hafalan ? $hafalan->ayat_terakhir : 0;
            $status = $hafalan ? $hafalan->status : 'Belum';
            $persentase = ($terakhir / $surah->total_ayat) * 100;
        @endphp
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 relative">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                        {{ $surah->nama_arab }} 
                        <span class="text-sm font-semibold">{{ $surah->nomor_surah }}. {{ $surah->nama_surah }}</span>
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Total ayat: {{ $surah->total_ayat }} | Terakhir: {{ $terakhir }}</p>
                </div>
                <div>
                    @if($status == 'Selesai')
                        <span class="bg-[#28a745] text-white text-[11px] px-2 py-0.5 rounded-full font-medium tracking-wide">Selesai</span>
                    @elseif($status == 'Proses')
                        <span class="bg-[#3b82f6] text-white text-[11px] px-2 py-0.5 rounded-full font-medium tracking-wide">Proses</span>
                    @endif
                </div>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                <div class="bg-[#0056b3] h-2 rounded-full" style="width: {{ $persentase }}%"></div>
            </div>

            <div class="flex justify-between items-center text-xs border-t pt-3 mt-2">
                <span class="text-gray-400">Diubah {{ $hafalan ? $hafalan->updated_at->diffForHumans() : '-' }}</span>
                <div class="flex gap-2 items-center">
                    @if($hafalan && $hafalan->setorans->count() > 0)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded font-semibold text-[10px]">Nilai: {{ $hafalan->setorans->first()->nilai ?? '-' }}</span>
                    @endif
                    <a href="{{ route('hafalan.detail', ['user_id' => $student->id, 'surah_id' => $surah->id]) }}" class="bg-[#3b82f6] text-white px-3 py-1 rounded hover:bg-blue-600 transition">Detail</a>
                    <button onclick="openSetorModal({{ $surah->id }}, '{{ $surah->nama_surah }}', '{{ $surah->nama_arab }}', {{ $surah->total_ayat }}, {{ $terakhir }})" class="bg-[#28a745] text-white px-3 py-1 rounded hover:bg-green-600 transition">Setor Hafalan</button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div id="setorModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl border border-gray-200">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Setor Hafalan</h3>
            <button onclick="closeSetorModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('hafalan.storeSetoran') }}" method="POST" class="px-6 py-4">
            @csrf
            <input type="hidden" name="user_id" value="{{ $student->id }}">
            <input type="hidden" name="surah_id" id="modal_surah_id">
            
            <p class="text-sm text-gray-600 mb-4" id="modal_surah_info"></p>

            <div class="flex gap-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ayat Mulai</label>
                    <input type="number" name="ayat_mulai" id="modal_ayat_mulai" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ayat Selesai</label>
                    <input type="number" name="ayat_selesai" id="modal_ayat_selesai" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nilai (opsional)</label>
                <input type="number" name="nilai" min="0" max="100" placeholder="0-100" class="w-1/2 border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                <textarea name="catatan" rows="2" placeholder="Catatan singkat" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <p class="text-xs text-gray-500 mb-6" id="modal_saran_ayat"></p>

            <div class="flex justify-end gap-2 border-t pt-4">
                <button type="button" onclick="closeSetorModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#0056b3] border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openSetorModal(surahId, namaSurah, namaArab, totalAyat, terakhir) {
        document.getElementById('setorModal').classList.remove('hidden');
        document.getElementById('modal_surah_id').value = surahId;
        
        let saranMulai = terakhir < totalAyat ? terakhir + 1 : totalAyat;
        document.getElementById('modal_surah_info').innerText = `Surah: ${namaArab} ${namaSurah} (Jumlah ayat: ${totalAyat}), terakhir: ${terakhir}`;
        document.getElementById('modal_ayat_mulai').value = saranMulai;
        document.getElementById('modal_ayat_selesai').value = saranMulai;
        document.getElementById('modal_saran_ayat').innerText = `Rentang 1 s.d. ${totalAyat}. Mulai disarankan: ${saranMulai}.`;
    }

    function closeSetorModal() {
        document.getElementById('setorModal').classList.add('hidden');
    }
</script>
@endpush
@endsection