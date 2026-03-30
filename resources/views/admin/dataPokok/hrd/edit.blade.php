@extends('layouts.main')
@section('title', 'Edit HRD')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <h2 class="text-base font-semibold text-gray-700">Edit HRD</h2>
        <a href="{{ route('hrd.index') }}" class="bg-[#f59e0b] hover:bg-yellow-600 text-white w-8 h-8 rounded flex items-center justify-center transition">
            <i class="fas fa-undo text-sm"></i>
        </a>
    </div>

    <form action="{{ route('hrd.store') }}" method="PUT" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama</label>
                <input type="text" name="name" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">No. Handphone</label>
                <input type="text" name="no_handphone" class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500 bg-gray-50">
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">Peran</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="role" value="admin" class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 border border-gray-300 px-4 py-1.5 rounded bg-white">Admin</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="role" value="teacher" checked class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 border border-gray-300 px-4 py-1.5 rounded bg-white">Guru</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Password</label>
                <input type="password" name="password" placeholder="........" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500 bg-gray-50">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full border-gray-300 rounded border p-2 text-sm focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">
            <a href="{{ route('hrd.index') }}" class="bg-[#f59e0b] text-white px-6 py-2 rounded text-sm font-medium hover:bg-yellow-600 transition">Batal</a>
            <button type="submit" class="bg-[#0056b3] text-white px-6 py-2 rounded text-sm font-medium hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection