@extends('layouts.main')
@section('title', 'Detail Ekstrakurikuler')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Detail Ekstrakurikuler</h2>
    <a href="{{ route('ekstrakurikuler.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white px-4 py-1.5 rounded text-sm transition">
        Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6 flex flex-col md:flex-row gap-4 items-end">
    <div class="w-full md:w-1/3">
        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Ekstrakurikuler</label>
        <div class="p-2 border border-gray-200 rounded bg-gray-50 text-gray-700 text-sm font-semibold uppercase">{{ $ekskul->nama }}</div>
    </div>
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-semibold text-gray-500 mb-1">Periode</label>
        <select class="w-full border-gray-300 border p-2 rounded text-sm"><option>Semua</option></select>
    </div>
    <div class="w-full md:w-1/4">
        <label class="block text-xs font-semibold text-gray-500 mb-1">Semester</label>
        <select class="w-full border-gray-300 border p-2 rounded text-sm"><option>Semester Ganjil</option></select>
    </div>
    <div>
        <button class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm">Filter</button>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="px-6 py-3 border-b flex justify-between items-center bg-gray-50">
        <h3 class="font-semibold text-gray-700 text-sm">Mentor</h3>
        <button class="bg-[#0056b3] text-white px-3 py-1.5 rounded text-xs">Tambah Mentor Baru</button>
    </div>
    <table class="w-full text-sm text-left">
        <thead class="bg-white border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr><th class="px-6 py-3 w-12">No</th><th class="px-6 py-3">Nama Mentor</th><th class="px-6 py-3">Email</th><th class="px-6 py-3">Semester</th><th class="px-6 py-3 w-20">Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($ekskul->mentors as $index => $mentor)
            <tr class="border-b"><td class="px-6 py-3">{{ $index+1 }}</td><td class="px-6 py-3">{{ $mentor->user->name ?? '-' }}</td><td class="px-6 py-3">{{ $mentor->user->email ?? '-' }}</td><td class="px-6 py-3">{{ $mentor->semester }}</td><td class="px-6 py-3"><button class="bg-[#dc3545] text-white px-2 py-1 rounded text-xs">Delete</button></td></tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-col md:flex-row gap-4 items-center bg-gray-50">
        <h3 class="font-semibold text-gray-700 text-sm w-full md:w-auto md:mr-4">Daftar Siswa</h3>
        <select class="flex-grow border-gray-300 border p-2 rounded text-sm">
            <option>Pilih Siswa...</option>
            @foreach($students as $student) <option value="{{ $student->id }}">{{ $student->name }}</option> @endforeach
        </select>
        <button class="bg-[#0056b3] text-white px-4 py-2 rounded text-sm whitespace-nowrap">Tambah Siswa</button>
    </div>
    <table class="w-full text-sm text-left">
        <thead class="bg-white border-b border-gray-200 text-gray-500 uppercase text-xs">
            <tr><th class="px-6 py-3 w-12">No</th><th class="px-6 py-3">Nama Siswa</th><th class="px-6 py-3 w-32">Kelas</th><th class="px-6 py-3 w-20">Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($ekskul->siswas as $index => $siswa)
            <tr class="border-b"><td class="px-6 py-3">{{ $index+1 }}</td><td class="px-6 py-3">{{ $siswa->user->name ?? '-' }}</td><td class="px-6 py-3">VII-A</td><td class="px-6 py-3"><button class="bg-[#dc3545] text-white px-2 py-1 rounded text-xs">Hapus</button></td></tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection