@extends('layouts.main')
@section('title', 'Pendidik & Tenaga Kependidikan')
@section('content')

<div class="bg-white rounded-t-lg shadow-sm border border-gray-200 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Pendidik dan Tenaga Kependidikan</h2>
    <div class="flex gap-2">
        <button class="bg-[#f59e0b] hover:bg-yellow-600 text-white px-4 py-1.5 rounded text-sm transition font-medium flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Upload
        </button>
        <a href="{{ route('hrd.create') }}" class="bg-[#0056b3] hover:bg-blue-700 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-plus text-sm"></i>
        </a>
    </div>
</div>

<div class="bg-white shadow-sm border border-t-0 border-gray-200 overflow-hidden rounded-b-lg">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-4 w-12">No</th>
                <th class="px-6 py-4 w-40 text-center">Aksi</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">No. Handphone</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Peran</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($hrds as $index => $item)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-1.5 justify-center">
                        <a href="{{ route('hrd.edit', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-blue-600 w-8 h-8 flex items-center justify-center rounded bg-white transition"><i class="fas fa-edit text-xs"></i></a>
                        <form action="{{ route('hrd.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus HRD ini?');">
                            @csrf @method('DELETE')
                            <button class="border border-gray-300 text-gray-500 hover:text-red-600 w-8 h-8 flex items-center justify-center rounded bg-white transition"><i class="fas fa-trash-alt text-xs"></i></button>
                        </form>
                        <a href="{{ route('hrd.subject', $item->id) }}" class="border border-gray-300 text-gray-500 hover:text-green-600 w-8 h-8 flex items-center justify-center rounded bg-white transition" title="Mata Pelajaran"><i class="far fa-folder-open text-xs"></i></a>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">{{ $item->name }}</div>
                    <div class="text-[11px] text-gray-500 mt-0.5">
                        {{ $item->mataPelajarans->pluck('nama_pelajaran')->implode(', ') ?: '-' }}
                    </div>
                </td>
                <td class="px-6 py-4">{{ $item->no_handphone ?? '-' }}</td>
                <td class="px-6 py-4">{{ $item->email }}</td>
                <td class="px-6 py-4 capitalize">{{ $item->role == 'teacher' ? 'Guru' : $item->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection