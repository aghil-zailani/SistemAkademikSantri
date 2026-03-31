@extends('layouts.main')
@section('title', 'Rombongan Belajar')
@section('content')

<div class="bg-white rounded-t-lg shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center">
    <h2 class="text-sm font-semibold text-[#0056b3]">Referensi <span class="text-gray-500">> Rombongan Belajar</span></h2>
    <button onclick="openAddModal()" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-plus text-sm"></i>
    </button>
</div>

<div class="bg-white shadow-sm border border-t-0 border-gray-200 overflow-hidden rounded-b-lg">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-[11px]">
            <tr>
                <th class="px-6 py-3 w-12">No</th>
                <th class="px-6 py-3 w-48 text-center">Aksi</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Wali Kelas</th>
                <th class="px-6 py-3">Jenjang</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($rombel as $index => $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3">{{ $index + 1 }}</td>
                <td class="px-6 py-3 text-center">
                    <div class="flex justify-center gap-1">
                        <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama }}', '{{ $item->jenjang }}', '{{ $item->wali_kelas_id }}')" class="bg-[#0056b3] text-white px-2 py-0.5 text-[11px] rounded hover:bg-blue-700">Ubah</button>
                        <button onclick="openEditModal({{ $item->id }}, '{{ $item->nama }}', '{{ $item->jenjang }}', '{{ $item->wali_kelas_id }}')" class="bg-[#28a745] text-white px-2 py-0.5 text-[11px] rounded hover:bg-green-600">Wali Kelas</button>
                        <form action="{{ route('rombongan-belajar.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-[#f59e0b] text-white px-2 py-0.5 text-[11px] rounded hover:bg-yellow-600">Hapus</button>
                        </form>
                    </div>
                </td>
                <td class="px-6 py-3 font-semibold">{{ $item->nama }}</td>
                <td class="px-6 py-3">{{ $item->waliKelas->name ?? '-' }}</td>
                <td class="px-6 py-3">{{ $item->jenjang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="formModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 id="modalTitle" class="font-semibold text-gray-800 mb-4">Tambah Rombongan Belajar</h3>
        <form id="rombelForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="mb-3">
                <label class="block text-xs text-gray-700 mb-1">Nama Rombel</label>
                <input type="text" name="nama" id="inputNama" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            <div class="mb-3">
                <label class="block text-xs text-gray-700 mb-1">Jenjang</label>
                <input type="number" name="jenjang" id="inputJenjang" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            <div class="mb-5">
                <label class="block text-xs text-gray-700 mb-1">Wali Kelas</label>
                <select name="wali_kelas_id" id="inputWali" class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                    @endforeach
                </select>
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
        document.getElementById('modalTitle').innerText = 'Tambah Rombongan Belajar';
        document.getElementById('rombelForm').action = "{{ route('rombongan-belajar.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('rombelForm').reset();
        document.getElementById('formModal').classList.remove('hidden');
    }

    function openEditModal(id, nama, jenjang, wali_id) {
        document.getElementById('modalTitle').innerText = 'Ubah Rombongan Belajar';
        document.getElementById('rombelForm').action = `/rombongan-belajar/${id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('inputNama').value = nama;
        document.getElementById('inputJenjang').value = jenjang;
        document.getElementById('inputWali').value = wali_id;
        document.getElementById('formModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('formModal').classList.add('hidden');
    }
</script>
@endpush
@endsection