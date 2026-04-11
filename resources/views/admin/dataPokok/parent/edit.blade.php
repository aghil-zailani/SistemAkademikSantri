@extends('layouts.main')
@section('title', 'Ubah Orangtua/Wali Siswa')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Ubah Orangtua/Wali Siswa</h2>
        <a href="{{ route('orangtua.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-undo text-sm"></i>
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <h3 class="text-sm font-bold text-red-800">Gagal menyimpan data!</h3>
            </div>
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orangtua.update', $orangtua->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-4 mb-6">
            <div class="w-full">
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Nama</label>
                <input type="text" name="nama" value="{{ $orangtua->nama }}" required class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white uppercase">
            </div>

            <div class="w-full">
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wider">Nomor Handphone</label>
                <input type="text" name="no_handphone" value="{{ $orangtua->no_handphone }}" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
            </div>
        </div>

        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
            <a href="{{ route('orangtua.index') }}" class="px-6 py-2 bg-[#f59e0b] text-white rounded text-sm font-medium hover:bg-yellow-600 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-[#0056b3] text-white rounded text-sm font-medium hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection