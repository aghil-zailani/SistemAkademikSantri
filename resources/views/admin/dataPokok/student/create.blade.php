@extends('layouts.main')
@section('title', 'Tambah Siswa')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">Tambah Siswa</h2>
        <a href="{{ route('siswa.index') }}" class="border border-gray-300 px-4 py-1.5 rounded text-sm text-gray-600 hover:bg-gray-50 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('siswa.store') }}" method="POST" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NISN <span class="text-red-500">*</span></label>
                <input type="text" name="nisn" placeholder="Nomor Induk Siswa Nasional" required class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                <input type="text" name="nis" placeholder="Nomor Induk Sekolah" class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" placeholder="Kota/Kabupaten" class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div class="w-full md:w-1/2 mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">ID Kartu</label>
            <input type="text" name="id_kartu" placeholder="........" class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-gray-50">
        </div>

        <hr class="mb-6 border-gray-200">

        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-700 mb-1">Informasi User Login (Opsional)</h3>
            <p class="text-xs text-gray-500 mb-4">Isi jika ingin membuat akun login untuk siswa</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama User</label>
                    <input type="text" name="nama_user" placeholder="Nama untuk login" class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <p class="text-[11px] text-gray-500 mt-1">Jika kosong, akan menggunakan nama siswa</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email User</label>
                    <input type="email" name="email_user" placeholder="email@example.com" class="w-full border-gray-300 rounded border p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <p class="text-[11px] text-gray-500 mt-1">Jika diisi, akan otomatis dibuatkan akun login</p>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center bg-gray-50 -m-6 mt-2 p-4 border-t border-gray-200 rounded-b-lg">
            <a href="{{ route('siswa.index') }}" class="bg-[#f59e0b] text-white px-6 py-2 rounded text-sm font-medium hover:bg-yellow-600 transition">Batal</a>
            <button type="submit" class="bg-[#0056b3] text-white px-6 py-2 rounded text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection