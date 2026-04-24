@extends('layouts.main')
@section('title', 'Input Presensi')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6 border-b pb-4">
        <h2 class="text-lg font-semibold text-gray-800">Input Presensi Siswa</h2>
    </div>

    <form action="{{ route('presensi.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="rombongan_belajar_id" id="kelas_selector" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($rombels as $rombel)
                        <option value="{{ $rombel->id }}">{{ $rombel->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran (Opsional)</label>
                <select name="mata_pelajaran_id" id="mapel_selector" class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Presensi Harian Umum --</option>
                    @foreach($mataPelajarans as $mp)
                        <option value="{{ $mp->id }}">{{ $mp->nama_mata_pelajaran }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase border-b border-gray-200">
                        <th class="py-3 px-4 w-12">NO</th>
                        <th class="py-3 px-4">NAMA SISWA</th>
                        <th class="py-3 px-4 text-center">KEHADIRAN</th>
                        <th class="py-3 px-4 w-64">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody id="student_table_body">
                    <tr>
                        <td colspan="4" class="py-6 text-center text-sm text-gray-500">Silahkan pilih Tanggal dan Kelas terlebih dahulu.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button type="submit" id="btn_submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow-sm transition disabled:opacity-50" disabled>
                Simpan Presensi
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('tanggal');
    const kelasSelector = document.getElementById('kelas_selector');
    const mapelSelector = document.getElementById('mapel_selector');
    const tableBody = document.getElementById('student_table_body');
    const btnSubmit = document.getElementById('btn_submit');

    function fetchStudents() {
        const rombelId = kelasSelector.value;
        const tanggal = tanggalInput.value;
        const mapelId = mapelSelector.value;
        
        if (!rombelId || !tanggal) {
            tableBody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-sm text-gray-500">Silahkan pilih Tanggal dan Kelas.</td></tr>`;
            btnSubmit.disabled = true;
            return;
        }

        tableBody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-sm text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat daftar siswa...</td></tr>`;

        // URL Parameters
        let url = `{{ route('get.students.presensi') }}?rombel_id=${rombelId}&tanggal=${tanggal}&mapel_id=${mapelId}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                
                if (data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-sm text-red-500">Tidak ada siswa di kelas ini.</td></tr>`;
                    btnSubmit.disabled = true;
                    return;
                }

                data.forEach((student, index) => {
                    // Cek status yang aktif
                    const isH = student.status === 'Hadir' ? 'checked' : '';
                    const isS = student.status === 'Sakit' ? 'checked' : '';
                    const isI = student.status === 'Izin' ? 'checked' : '';
                    const isA = student.status === 'Alpa' ? 'checked' : '';

                    const row = `
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">${index + 1}</td>
                            <td class="py-3 px-4 text-sm font-medium text-gray-800">${student.name}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center space-x-4">
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="status[${student.id}]" value="Hadir" class="text-green-600 focus:ring-green-500 w-5 h-5 mb-1" ${isH}>
                                        <span class="text-xs text-gray-500">H</span>
                                    </label>
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="status[${student.id}]" value="Sakit" class="text-yellow-500 focus:ring-yellow-500 w-5 h-5 mb-1" ${isS}>
                                        <span class="text-xs text-gray-500">S</span>
                                    </label>
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="status[${student.id}]" value="Izin" class="text-blue-500 focus:ring-blue-500 w-5 h-5 mb-1" ${isI}>
                                        <span class="text-xs text-gray-500">I</span>
                                    </label>
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="status[${student.id}]" value="Alpa" class="text-red-600 focus:ring-red-500 w-5 h-5 mb-1" ${isA}>
                                        <span class="text-xs text-gray-500">A</span>
                                    </label>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <input type="text" name="keterangan[${student.id}]" value="${student.keterangan}" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 py-1" placeholder="Catatan (opsional)">
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });

                btnSubmit.disabled = false;
            });
    }

    // Trigger fetch setiap kali ada perubahan pada filter
    tanggalInput.addEventListener('change', fetchStudents);
    kelasSelector.addEventListener('change', fetchStudents);
    mapelSelector.addEventListener('change', fetchStudents);
});
</script>
@endpush