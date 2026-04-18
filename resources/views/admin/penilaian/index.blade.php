@extends('layouts.main')
@section('title', 'Nilai Siswa')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Nilai Siswa</h2>
        
        <div class="flex items-center space-x-2 mt-4 md:mt-0 w-full md:w-auto block text-xs font-medium text-gray-600 mb-1.5">
            <form action="{{ route('penilaian.index') }}" method="GET" class="flex items-center">
                <select name="jenis_ujian" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="Semua">-- Semua --</option>
                    <option value="Ulangan Harian" {{ request('jenis_ujian') == 'Ulangan Harian' ? 'selected' : '' }}>Ulangan Harian</option>
                    <option value="Sumatif Tengah Semester (STS)" {{ request('jenis_ujian') == 'Sumatif Tengah Semester (STS)' ? 'selected' : '' }}>Sumatif Tengah Semester (STS)</option>
                    <option value="Sumatif Akhir Semester (SAS)" {{ request('jenis_ujian') == 'Sumatif Akhir Semester (SAS)' ? 'selected' : '' }}>Sumatif Akhir Semester (SAS)</option>
                    <option value="Suluk" {{ request('jenis_ujian') == 'Suluk' ? 'selected' : '' }}>Suluk</option>
                </select>
            </form>

            <a href="{{ route('penilaian.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition shadow-sm">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-semibold text-gray-500 uppercase">
                    <th class="py-3 px-4 w-12">NO</th>
                    <th class="py-3 px-4 w-24">AKSI</th>
                    <th class="py-3 px-4">MATA PELAJARAN</th>
                    <th class="py-3 px-4">JENIS</th>
                    <th class="py-3 px-4">KELAS</th>
                    <th class="py-3 px-4 w-20">KKM</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penilaians as $index => $item)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-sm">{{ $penilaians->firstItem() + $index }}</td>
                    <td class="py-3 px-4 text-sm flex space-x-2">
                        <button class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                    </td>
                    <td class="py-3 px-4 text-sm">{{ $item->mataPelajaran->nama ?? '-' }}</td>
                    <td class="py-3 px-4 text-sm">{{ $item->jenis_ujian }}</td>
                    <td class="py-3 px-4 text-sm">{{ $item->rombonganBelajar->nama ?? '-' }}</td>
                    <td class="py-3 px-4 text-sm font-semibold">{{ $item->kkm }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 px-4 text-center text-sm text-gray-500">
                        Data belum tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $penilaians->links() }}
    </div>
</div>
@endsection