@extends('layouts.main')

@section('title', 'Tambah Tagihan - Keuangan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-700">Tambah Tagihan</h2>
    </div>

    <form action="{{ route('tagihan.store') }}" method="POST">
        @csrf
        <div class="px-6 py-5 space-y-4 text-sm">
            <!-- Nama -->
            <div>
                <label for="nama" class="block text-gray-700 font-medium mb-1.5">Nama</label>
                <input type="text" name="nama" id="nama" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror" value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Akun Terkait -->
            <div>
                <label for="akun" class="block text-gray-700 font-medium mb-1.5">Akun Terkait</label>
                <select name="akun" id="akun" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('akun') border-red-500 @enderror" required>
                    <option value="">-- Pilih --</option>
                    @foreach($akunOptions as $akun)
                        <option value="{{ $akun }}" {{ old('akun') == $akun ? 'selected' : '' }}>{{ $akun }}</option>
                    @endforeach
                </select>
                @error('akun')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tanggal Jatuh Tempo -->
            <div>
                <label for="tanggal_jatuh_tempo" class="block text-gray-700 font-medium mb-1.5">Tanggal Jatuh Tempo</label>
                <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_jatuh_tempo') border-red-500 @enderror" value="{{ old('tanggal_jatuh_tempo') }}" required>
                @error('tanggal_jatuh_tempo')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-2 rounded-b-lg">
            <a href="{{ route('tagihan.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 text-sm rounded transition font-medium">Batal</a>
            <button type="submit" class="bg-[#0056b3] hover:bg-blue-700 text-white px-4 py-2 text-sm rounded transition font-medium">Simpan</button>
        </div>
    </form>
</div>
@endsection
