@extends('layouts.main')
@section('title', 'Pelanggaran Siswa - eduSantri')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Pelanggaran Siswa</h2>
    <button onclick="openModal('tambahModal')" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-plus text-sm"></i>
    </button>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">No</th>
                    <th class="px-6 py-4 w-32">Aksi</th>
                    <th class="px-6 py-4 w-1/4">Siswa</th>
                    <th class="px-6 py-4">Pelanggaran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($pelanggarans as $index => $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <form action="{{ route('pelanggaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border border-gray-300 text-gray-600 hover:text-red-600 hover:border-red-600 w-8 h-8 flex items-center justify-center rounded bg-white transition">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                        
                        <button onclick="openEditModal({{ $item->id }}, '{{ $item->tanggal }}', {{ $item->user_id }}, {{ $item->jenis_pelanggaran_id }})" class="border border-gray-300 text-gray-600 hover:text-blue-600 hover:border-blue-600 w-8 h-8 flex items-center justify-center rounded bg-white transition">
                            <i class="fas fa-edit text-xs"></i>
                        </button>
                    </td>
                    <td class="px-6 py-4 uppercase">{{ $item->user->name ?? 'Anonim' }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium mb-1">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</div>
                        <div class="text-gray-600">{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                        <div class="text-gray-500 text-xs mt-1">Point : {{ $item->jenisPelanggaran->poin ?? 0 }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data pelanggaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="tambahModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="bg-white w-full max-w-4xl mx-4 rounded-lg shadow-xl border border-gray-200">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Pelanggaran Siswa</h3>
            <button type="button" onclick="closeModal('tambahModal')" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
                <i class="fas fa-undo text-sm"></i>
            </button>
        </div>
        
        <form action="{{ route('pelanggaran.store') }}" method="POST" class="p-6 bg-gray-50">
            @csrf
            
            <div class="space-y-4">
                <div class="w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="far fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                    <select name="user_id" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="" disabled selected>Pilih</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggaran</label>
                    <select name="jenis_pelanggaran_id" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="" disabled selected>Pilih</option>
                        @foreach($jenisPelanggarans as $jp)
                            <option value="{{ $jp->id }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-[#0056b3] border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="bg-white w-full max-w-4xl mx-4 rounded-lg shadow-xl border border-gray-200">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Edit Pelanggaran Siswa</h3>
            <button type="button" onclick="closeModal('editModal')" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
                <i class="fas fa-undo text-sm"></i>
            </button>
        </div>
        
        <form id="editForm" method="POST" class="p-6 bg-gray-50">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div class="w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="far fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" name="tanggal" id="edit_tanggal" required class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                    <select name="user_id" id="edit_user_id" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggaran</label>
                    <select name="jenis_pelanggaran_id" id="edit_jenis_pelanggaran_id" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                        @foreach($jenisPelanggarans as $jp)
                            <option value="{{ $jp->id }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-[#0056b3] border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openEditModal(id, tanggal, userId, jenisId) {
        // Set action form dinamis sesuai ID
        document.getElementById('editForm').action = `/pelanggaran/${id}`;
        
        // Populate data ke dalam input
        document.getElementById('edit_tanggal').value = tanggal;
        document.getElementById('edit_user_id').value = userId;
        document.getElementById('edit_jenis_pelanggaran_id').value = jenisId;
        
        openModal('editModal');
    }
</script>
@endpush
@endsection