@extends('layouts.main')
@section('title', 'Edit Rekam Medis')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">Edit Rekam Medis</h2>
    <a href="{{ route('kesehatan.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
        <i class="fas fa-undo text-sm"></i>
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('kesehatan.update', $medicalRecord->id) }}" method="PUT">
        @csrf
        @method('PUT')

        <div class="space-y-4 mb-6">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select name="user_id" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="" disabled selected>Pilih Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keluhan_masuk" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('kesehatan.index') }}" class="px-4 py-2 bg-[#f59e0b] text-white rounded-md text-sm font-medium hover:bg-yellow-600 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#0056b3] text-white rounded-md text-sm font-medium hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection