@extends('layouts.main')
@section('title', 'Daftar Tagihan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Tagihan</h2>
        <a href="{{ route('admin.tagihan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition shadow-sm w-8 h-8 flex items-center justify-center">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-semibold text-gray-500 uppercase">
                    <th class="py-3 px-4 w-12">NO</th>
                    <th class="py-3 px-4">NAMA</th>
                    <th class="py-3 px-4">AKUN</th>
                    <th class="py-3 px-4">SUDAH BAYAR</th>
                    <th class="py-3 px-4">BELUM BAYAR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihans as $index => $item)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-4 px-4 text-sm align-top">{{ $tagihans->firstItem() + $index }}</td>
                    <td class="py-4 px-4 align-top">
                        <div class="text-sm font-medium text-gray-800 mb-1">{{ $item->nama }}</div>
                        <div class="flex space-x-1">
                            <a href="{{ route('admin.tagihan.show', $item->id) }}" class="bg-green-500 hover:bg-green-600 text-white text-[10px] px-2 py-1 rounded">Detail</a>
                            </div>
                    </td>
                    <td class="py-4 px-4 text-sm text-gray-600 align-top">{{ $item->akun->nama ?? '-' }}</td>

                    <td class="py-4 px-4 text-sm align-top">
                        <div class="text-gray-800">{{ number_format($item->sudah_bayar_nominal, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">{{ $item->sudah_bayar_count }} santri</div>
                    </td>
                    <td class="py-4 px-4 text-sm align-top">
                        <div class="text-gray-800">{{ number_format($item->belum_bayar_nominal, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">{{ $item->belum_bayar_count }} santri</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-sm text-gray-500">Belum ada data tagihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $tagihans->links() }}
    </div>
</div>
@endsection