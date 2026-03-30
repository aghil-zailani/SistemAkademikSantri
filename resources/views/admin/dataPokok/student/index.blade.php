@extends('layouts.main')
@section('title', 'Data Siswa')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Data Siswa</h2>
    <div class="flex gap-2">
        <button class="bg-[#f59e0b] hover:bg-yellow-600 text-white px-4 py-1.5 rounded text-sm transition font-medium flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Upload
        </button>
        <a href="{{ route('siswa.create') }}" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-plus text-sm"></i>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded bg-blue-100 flex items-center justify-center text-[#0056b3] text-xl"><i class="fas fa-users"></i></div>
        <div>
            <div class="font-bold text-gray-800">{{ $total }} Total</div>
            <div class="text-xs text-gray-500">Siswa terdaftar</div>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded bg-green-100 flex items-center justify-center text-green-600 text-xl"><i class="fas fa-id-card"></i></div>
        <div>
            <div class="font-bold text-gray-800">{{ $punyaKartu }} Punya Kartu</div>
            <div class="text-xs text-gray-500">Sudah memiliki ID kartu</div>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl"><i class="fas fa-id-card-clip"></i></div>
        <div>
            <div class="font-bold text-gray-800">{{ $tanpaKartu }} Tanpa Kartu</div>
            <div class="text-xs text-gray-500">Belum memiliki ID kartu</div>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded bg-blue-50 flex items-center justify-center text-blue-500 text-xl"><i class="fas fa-user-check"></i></div>
        <div>
            <div class="font-bold text-gray-800">{{ $punyaUser }} Punya User</div>
            <div class="text-xs text-gray-500">Memiliki akun login</div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4 w-12">No</th>
                <th class="px-6 py-4 w-1/4">Siswa</th>
                <th class="px-6 py-4">NISN / NIS</th>
                <th class="px-6 py-4">Tempat, Tanggal Lahir</th>
                <th class="px-6 py-4 text-center">ID Kartu</th>
                <th class="px-6 py-4 text-center">User Login</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($students as $index => $item)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-gray-800 uppercase">{{ $item->nama_lengkap }}</div>
                    <div class="text-xs text-gray-500 truncate w-48">https://app.edusantri.com/public/student?id={{ $item->id }}</div>
                    <div class="text-xs text-gray-500">VA : {{ $item->va_number }}</div>
                </td>
                <td class="px-6 py-4 font-bold">
                    <span class="bg-[#0056b3] text-white px-2 py-0.5 rounded text-xs">{{ $item->nisn }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">{{ $item->tempat_lahir ?? '-' }}</div>
                    <div class="text-xs text-gray-500">{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                </td>
                <td class="px-6 py-4 text-center">
                    @if($item->id_kartu)
                        <span class="bg-[#28a745] text-white px-2 py-0.5 rounded text-xs font-semibold">Ada</span>
                    @else
                        <span class="bg-gray-400 text-white px-2 py-0.5 rounded text-xs font-semibold">Tidak Ada</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if($item->user_id)
                        <span class="bg-[#0056b3] text-white px-2 py-0.5 rounded text-xs font-semibold">Ada</span>
                    @else
                        <span class="bg-gray-500 text-white px-2 py-0.5 rounded text-xs font-semibold">Tidak Ada</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-1">
                        <a href="{{ route('siswa.show', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-blue-600 w-8 h-8 flex items-center justify-center rounded bg-white transition"><i class="fas fa-eye text-xs"></i></a>
                        <a href="{{ route('siswa.edit', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-green-600 w-8 h-8 flex items-center justify-center rounded bg-white transition"><i class="fas fa-edit text-xs"></i></a>
                        <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?');">
                            @csrf @method('DELETE')
                            <button class="border border-gray-300 text-gray-500 hover:text-red-600 w-8 h-8 flex items-center justify-center rounded bg-white transition"><i class="fas fa-trash-alt text-xs"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection