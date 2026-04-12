@extends('layouts.main')
@section('title', 'Data Kelas')
@section('content')

<div class="bg-white rounded-t-lg shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center">
    <h2 class="text-sm font-semibold text-[#0056b3]">Referensi <span class="text-gray-500">> Kelas</span></h2>
    <button onclick="openAddModal()" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-plus text-sm"></i>
    </button>
</div>

<div class="bg-white shadow-sm border border-t-0 border-gray-200 overflow-hidden rounded-b-lg">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-[11px]">
            <tr>
                <th class="px-6 py-3 w-12">No</th>
                <th class="px-6 py-3 w-32 text-center">Aksi</th>
                <th class="px-6 py-3">Nama Kelas</th>
                <th class="px-6 py-3">Tingkat</th>
                <th class="px-6 py-3">Tahun Ajaran</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($kelas as $index => $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3">{{ $index + 1 }}</td>
                <td class="px-6 py-3 text-center">
                    <div class="flex justify-center gap-1">
                        <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama_kelas }}', '{{ $item->tingkat }}', '{{ $item->tahun_ajaran }}')" class="bg-[#0056b3] text-white px-2 py-0.5 text-[11px] rounded hover:bg-blue-700">Ubah</button>
                        <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kelas ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-[#f59e0b] text-white px-2 py-0.5 text-[11px] rounded hover:bg-yellow-600">Hapus</button>
                        </form>
                    </div>
                </td>
                <td class="px-6 py-3 font-medium">{{ $item->nama_kelas }}</td>
                <td class="px-6 py-3">{{ $item->tingkat ?? '-' }}</td>
                <td class="px-6 py-3">{{ $item->tahun_ajaran ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="formModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 id="modalTitle" class="font-semibold text-gray-800 mb-4">Tambah Kelas</h3>
        <form id="kelasForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="mb-3">
                <label class="block text-xs text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="inputNama" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            <div class="mb-3">
                <label class="block text-xs text-gray-700 mb-1">Tingkat (Opsional)</label>
                <input type="text" name="tingkat" id="inputTingkat" placeholder="Contoh: VII" class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            <div class="mb-5">
                <label class="block text-xs text-gray-700 mb-1">Tahun Ajaran (Opsional)</label>
                <input type="text" name="tahun_ajaran" id="inputTahun" placeholder="Contoh: 2025/2026" class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            
            <div class="flex justify-end gap-2 border-t pt-4">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded text-sm hover:bg-gray-600">Batal</button>
                <button type="submit" class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Kelas';
        document.getElementById('kelasForm').action = "{{ route('kelas.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('kelasForm').reset();
        document.getElementById('formModal').classList.remove('hidden');
    }
    function openEditModal(id, nama, tingkat, tahun) {
        document.getElementById('modalTitle').innerText = 'Ubah Kelas';
        document.getElementById('kelasForm').action = `/kelas/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('inputNama').value = nama;
        document.getElementById('inputTingkat').value = tingkat;
        document.getElementById('inputTahun').value = tahun;
        document.getElementById('formModal').classList.remove('hidden');
    }
    function closeModal() { document.getElementById('formModal').classList.add('hidden'); }
</script>
@endpush
@endsection