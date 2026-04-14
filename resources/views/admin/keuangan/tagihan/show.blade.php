@extends('layouts.main')

@section('title', 'Detail Tagihan - Keuangan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Daftar Pembayaran : {{ $tagihan->nama }}</h2>
    <a href="{{ route('tagihan.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 text-sm rounded transition font-medium flex items-center justify-center">
        <i class="fas fa-undo"></i>
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex flex-wrap gap-2">
    <button class="bg-[#3b82f6] hover:bg-blue-600 text-white px-4 py-2 text-sm rounded transition font-medium flex items-center gap-2">
        <i class="fas fa-file-invoice"></i> Tagih Pembayaran
    </button>
    <button onclick="document.getElementById('modal-tambah-siswa').classList.remove('hidden')" class="bg-[#22c55e] hover:bg-green-600 text-white px-4 py-2 text-sm rounded transition font-medium flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Siswa
    </button>
    <button class="bg-[#f59e0b] hover:bg-yellow-600 text-white px-4 py-2 text-sm rounded transition font-medium flex items-center gap-2">
        <i class="fas fa-edit"></i> Ubah Nominal
    </button>
    <button class="bg-[#22c55e] hover:bg-green-600 text-white px-4 py-2 text-sm rounded transition font-medium flex items-center gap-2">
        <i class="fas fa-download"></i> Download Xls
    </button>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 w-16">NO</th>
                    <th class="px-6 py-4">NAMA</th>
                    <th class="px-6 py-4">JUMLAH</th>
                    <th class="px-6 py-4">STATUS</th>
                    <th class="px-6 py-4">TANGGAL BAYAR</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($tagihanStudents as $index => $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $tagihanStudents->firstItem() + $index }}</td>
                    <td class="px-6 py-4 uppercase font-medium">{{ $item->student->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $item->status }}</td>
                    <td class="px-6 py-4">{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('Y-m-d H:i:s') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada siswa yang ditambahkan ke tagihan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tagihanStudents->hasPages() || $tagihanStudents->total() === 0)
    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center bg-white">
        <div class="text-sm text-gray-500">
            Showing {{ $tagihanStudents->firstItem() ?? 0 }} to {{ $tagihanStudents->lastItem() ?? 0 }} of {{ number_format($tagihanStudents->total(), 0, ',', '.') }} entries
        </div>
        <div class="flex items-center gap-2">
            {{ $tagihanStudents->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>

<!-- Modal Tambah Siswa -->
<div id="modal-tambah-siswa" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Tambah Siswa ke Tagihan</h3>
            <button onclick="document.getElementById('modal-tambah-siswa').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('tagihan.addStudent', $tagihan->id) }}" method="POST">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                    <select name="student_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($allStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->nis }} - {{ $student->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tagihan</label>
                    <input type="number" name="jumlah" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="1850000" required>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2 text-sm">
                <button type="button" onclick="document.getElementById('modal-tambah-siswa').classList.add('hidden')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded transition font-medium">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
