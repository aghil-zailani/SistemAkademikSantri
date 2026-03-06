@extends('layouts.main')
@section('title', 'Hafalan Al Qur\'an')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 p-4">
    <h2 class="text-lg font-semibold text-gray-700">Hafalan Al Qur'an</h2>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 flex justify-end gap-2 border-b border-gray-100">
        <input type="text" placeholder="Cari nama atau NISN.." class="border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500">
        <select class="border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500">
            <option>Semua Kelas</option>
            <option>VII-A</option>
        </select>
        <button class="bg-[#0056b3] text-white px-4 py-1.5 rounded-md text-sm hover:bg-blue-700">Cari</button>
    </div>

    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase">
            <tr>
                <th class="px-6 py-4 w-16">No</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">Kelas</th>
                <th class="px-6 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($students as $index => $student)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4 font-medium">{{ $student->name }}</td>
                <td class="px-6 py-4">VII-A</td> <td class="px-6 py-4">
                    <a href="{{ route('hafalan.show', $student->id) }}" class="bg-[#0056b3] text-white px-3 py-1.5 rounded text-xs hover:bg-blue-700 transition">
                        Lihat Hafalan
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection