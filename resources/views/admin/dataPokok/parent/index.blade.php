@extends('layouts.main')
@section('title', 'Data Orangtua/Wali Siswa')
@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
    {!! session('success') !!}
</div>
@endif

<div class="bg-white rounded-t-lg shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Data Orangtua/Wali Siswa</h2>
    <button onclick="document.getElementById('tambahModal').classList.remove('hidden')" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-plus text-sm"></i>
    </button>
</div>

<div class="bg-white shadow-sm border border-t-0 border-gray-200 overflow-hidden rounded-b-lg">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4 w-12">No</th>
                <th class="px-6 py-4 w-52">Aksi</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">No. Handphone</th>
                <th class="px-6 py-4">Nama Siswa</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($orangtuas as $index => $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-1">
                        <form action="{{ route('orangtua.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="border border-gray-300 text-gray-500 hover:text-red-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Hapus"><i class="fas fa-trash-alt text-xs"></i></button>
                        </form>
                        <a href="{{ route('orangtua.edit', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-blue-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Edit"><i class="fas fa-edit text-xs"></i></a>
                        <a href="{{ route('orangtua.siswa', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-green-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Data Anak/Siswa"><i class="fas fa-user-friends text-xs"></i></a>
                        <form action="{{ route('orangtua.resetPassword', $item->id) }}" method="POST" onsubmit="return confirm('Generate password baru untuk parent ini?');" class="inline">
                            @csrf
                            <button type="submit" class="border border-gray-300 text-gray-500 hover:text-yellow-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Reset Password"><i class="fas fa-key text-xs"></i></button>
                        </form>
                        @php $waNumber = preg_replace('/^0/', '62', $item->no_handphone); @endphp
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="border border-gray-300 text-gray-500 hover:text-green-500 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Hubungi WA"><i class="fab fa-whatsapp text-xs"></i></a>
                    </div>
                </td>
                <td class="px-6 py-4 font-medium uppercase">{{ $item->nama }}</td>
                <td class="px-6 py-4">{{ $item->no_handphone ?? '-' }}</td>
                <td class="px-6 py-4 uppercase">
                    @forelse($item->students as $siswa)
                        <div class="mb-1">{{ $siswa->nama_lengkap }}</div>
                    @empty
                        <span class="text-xs text-gray-400 italic">Belum ada data siswa</span>
                    @endforelse
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="tambahModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambah Orangtua/Wali</h3>
        <form action="{{ route('orangtua.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" required class="w-full border-gray-300 rounded border p-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="mb-5">
                <label class="block text-sm text-gray-700 mb-1">Nomor Handphone</label>
                <input type="text" name="no_handphone" class="w-full border-gray-300 rounded border p-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="flex gap-2 justify-end">
                <button type="button" onclick="document.getElementById('tambahModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection