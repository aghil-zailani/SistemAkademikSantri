@extends('layouts.main')

@section('title', 'Pengasuhan - eduSantri')

@section('content')
<div class="mb-6">
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        
        <div class="px-6 py-4 flex flex-col md:flex-row md:items-center justify-between border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 md:mb-0">Pengasuhan</h2>
            
            <div class="flex items-center space-x-3">
                <form action="{{ route('pengasuhan.index') }}" method="GET" class="relative flex items-center border border-gray-300 rounded-md px-3 py-1.5 bg-white">
                    <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                    <input 
                        type="date" 
                        name="tanggal" 
                        value="{{ request('tanggal', date('Y-m-d')) }}" 
                        onchange="this.form.submit()"
                        class="text-sm text-gray-600 focus:outline-none bg-transparent"
                    >
                </form>
                
                <button onclick="openModal()" type="button" class="bg-[#0056b3] hover:bg-blue-700 text-white rounded-md w-8 h-8 flex items-center justify-center transition duration-200">
                    <i class="fas fa-plus text-sm"></i>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-2/3">Kegiatan</th>
                        <th scope="col" class="px-6 py-4 font-semibold w-1/3">Jumlah Siswa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($kegiatans as $kegiatan)
                        <tr class="bg-white hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 text-gray-700 font-medium">
                                {{ $kegiatan['nama'] }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-600 mb-1.5 font-medium">
                                        {{ $kegiatan['selesai'] }}/{{ $kegiatan['total'] }}
                                    </span>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        @php
                                            $persentase = $kegiatan['total'] > 0 
                                                ? ($kegiatan['selesai'] / $kegiatan['total']) * 100 
                                                : 0;
                                        @endphp
                                        <div class="bg-[#0056b3] h-1.5 rounded-full" style="width: {{ $persentase }}%"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="tambahModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl w-full">
            
            <div class="bg-white px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-semibold text-gray-800" id="modal-title">
                    Tambah Monitoring
                </h3>
                <button type="button" onclick="closeModal()" class="bg-[#f59e0b] hover:bg-yellow-600 text-white rounded px-2 py-1 focus:outline-none transition duration-150">
                    <i class="fas fa-undo text-sm"></i>
                </button>
            </div>

            <div class="px-6 py-6 bg-gray-50/50">
                <form action="#" method="POST" class="flex flex-col md:flex-row gap-4 items-center">
                    @csrf
                    
                    <div class="w-full md:w-1/4 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" name="tanggal_monitoring" value="{{ request('tanggal', date('Y-m-d')) }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                    </div>

                    <div class="w-full md:w-1/3">
                        <select name="kegiatan_id" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white cursor-pointer">
                            <option value="" disabled selected>Pilih Kegiatan</option>
                            @foreach($kegiatans as $kegiatan)
                                <option value="{{ $kegiatan['nama'] }}">{{ $kegiatan['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <select name="ruang_id" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white cursor-pointer">
                            <option value="Semua Ruang" selected>Semua Ruang</option>
                            <option value="1">Ruang Kelas A</option>
                            <option value="2">Ruang Kelas B</option>
                        </select>
                    </div>

                    <div class="w-full md:w-auto flex-grow">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#0056b3] hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            Tampilkan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk membuka modal
    function openModal() {
        document.getElementById('tambahModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('tambahModal').classList.add('hidden');
    }

    // Tutup modal jika user menekan tombol Escape di keyboard
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
</script>
@endpush