@extends('layouts.main')
@section('title', 'Tambah Tagihan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Tambah Tagihan</h2>
    </div>

    <form action="{{ route('admin.tagihan.store') }}" method="POST">
        @csrf
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('nama') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Akun Terkait</label>
                <select name="akun_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih --</option>
                    @foreach($akuns as $akun)
                        <option value="{{ $akun->id }}" {{ old('akun_id') == $akun->id ? 'selected' : '' }}>
                            {{ $akun->kode }} - {{ $akun->nama }}
                        </option>
                    @endforeach
                </select>
                @error('akun_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('tanggal_jatuh_tempo') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-8 border-t border-gray-100 pt-5">
            <a href="{{ route('admin.tagihan.index') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-6 rounded-md shadow-sm transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection