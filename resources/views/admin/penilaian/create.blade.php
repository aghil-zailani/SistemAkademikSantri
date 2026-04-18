@extends('layouts.main')
@section('title', 'Tambah Nilai Siswa')

@section('content')
<div class="py-2">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs text-gray-400 mb-0.5">Penilaian</p>
            <h2 class="text-lg font-semibold text-gray-800">Tambah Nilai Siswa</h2>
        </div>
        <a href="{{ route('penilaian.index') }}"
           class="inline-flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-lg
                  bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                <path d="M3 3v5h5"/>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf

        {{-- Informasi Ujian Card --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Informasi Ujian</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" required
                            class="block w-full text-sm text-gray-700 bg-white border border-gray-300 rounded-lg px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih mata pelajaran</option>
                        @foreach($mataPelajarans as $mp)
                            <option value="{{ $mp->id }}">{{ $mp->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Jenis Ujian</label>
                    <select name="jenis_ujian" required
                            class="block w-full text-sm text-gray-700 bg-white border border-gray-300 rounded-lg px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="Ulangan Harian">Ulangan Harian</option>
                        <option value="Sumatif Tengah Semester (STS)">Sumatif Tengah Semester (STS)</option>
                        <option value="Sumatif Akhir Semester (SAS)">Sumatif Akhir Semester (SAS)</option>
                        <option value="Suluk">Suluk</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">KKM</label>
                    <input type="number" name="kkm" placeholder="75" required
                           class="block w-full text-sm text-gray-700 bg-white border border-gray-300 rounded-lg px-3 py-2
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Kelas</label>
                    <select name="rombongan_belajar_id" id="kelas_selector" required
                            class="block w-full text-sm text-gray-700 bg-white border border-gray-300 rounded-lg px-3 py-2
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih kelas</option>
                        @foreach($rombels as $rombel)
                            <option value="{{ $rombel->id }}">{{ $rombel->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Capaian Kompetensi</label>
                <input type="text" name="capaian_kompetensi"
                       placeholder="Tuliskan capaian kompetensi..."
                       class="block w-full text-sm text-gray-700 bg-white border border-gray-300 rounded-lg px-3 py-2
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        {{-- Daftar Siswa Card --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Daftar Siswa</p>
                <span id="student_count" class="text-xs text-gray-400">—</span>
            </div>

            <table class="w-full border-collapse" style="table-layout: fixed;">
                <colgroup>
                    <col style="width: 52px;">
                    <col>
                    <col style="width: 140px;">
                </colgroup>
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="py-2.5 px-5 text-left text-xs font-semibold text-gray-400">No</th>
                        <th class="py-2.5 px-5 text-left text-xs font-semibold text-gray-400">Nama Siswa</th>
                        <th class="py-2.5 px-5 text-left text-xs font-semibold text-gray-400">Nilai</th>
                    </tr>
                </thead>
                <tbody id="student_table_body">
                    <tr>
                        <td colspan="3" class="py-12 px-5 text-center text-sm text-gray-400">
                            Belum ada kelas yang dipilih. Silahkan pilih kelas untuk menampilkan daftar siswa.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('penilaian.index') }}"
               class="inline-flex items-center text-sm px-5 py-2 rounded-lg
                      border border-gray-200 text-gray-500 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" id="btn_submit" disabled
                    class="text-sm px-5 py-2 rounded-lg font-medium border transition cursor-not-allowed
                           bg-gray-100 text-gray-400 border-gray-200">
                Simpan Nilai
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kelasSelector = document.getElementById('kelas_selector');
    const tableBody     = document.getElementById('student_table_body');
    const btnSubmit     = document.getElementById('btn_submit');
    const countEl       = document.getElementById('student_count');

    const emptyRow = `
        <tr>
            <td colspan="3" class="py-12 px-5 text-center">
                <div class="flex flex-col items-center gap-2 text-sm text-gray-400">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-30">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Pilih kelas untuk menampilkan daftar siswa
                </div>
            </td>
        </tr>`;

    const loadingRow = `
        <tr>
            <td colspan="3" class="py-12 px-5 text-center text-sm text-gray-400">
                <i class="fas fa-spinner fa-spin mr-1.5"></i> Memuat data siswa...
            </td>
        </tr>`;

    function enableSubmit(enabled) {
        btnSubmit.disabled = !enabled;
        if (enabled) {
            btnSubmit.className = 'text-sm px-5 py-2 rounded-lg font-medium border transition cursor-pointer bg-blue-500 text-white border-blue-500 hover:bg-blue-600';
        } else {
            btnSubmit.className = 'text-sm px-5 py-2 rounded-lg font-medium border transition cursor-not-allowed bg-gray-100 text-gray-400 border-gray-200';
        }
    }

    function makeStudentRow(student, index) {
        return `
            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                <td class="py-3 px-5 text-sm text-gray-400">${index + 1}</td>
                <td class="py-3 px-5 text-sm text-gray-800">${student.name}</td>
                <td class="py-2 px-5">
                    <input type="number"
                           name="nilai[${student.id}]"
                           min="0" max="100"
                           placeholder="0–100"
                           required
                           class="block w-full text-sm text-center text-gray-700 bg-white
                                  border border-gray-300 rounded-lg px-2 py-1.5
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           oninput="clampNilai(this)">
                </td>
            </tr>`;
    }

    kelasSelector.addEventListener('change', function () {
        const rombelId = this.value;

        if (!rombelId) {
            tableBody.innerHTML = emptyRow;
            countEl.textContent = '—';
            enableSubmit(false);
            return;
        }

        tableBody.innerHTML = loadingRow;

        const url = "{{ route('get.students', ':id') }}".replace(':id', rombelId);

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="3" class="py-12 px-5 text-center text-sm text-red-400">
                                Tidak ada siswa di kelas ini.
                            </td>
                        </tr>`;
                    countEl.textContent = '0 siswa';
                    enableSubmit(false);
                    return;
                }

                tableBody.innerHTML = data.map((s, i) => makeStudentRow(s, i)).join('');
                countEl.textContent = data.length + ' siswa';
                enableSubmit(true);
            })
            .catch(() => {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-12 px-5 text-center text-sm text-red-400">
                            Gagal memuat data. Silahkan coba lagi.
                        </td>
                    </tr>`;
                enableSubmit(false);
            });
    });

    window.clampNilai = function (input) {
        const v = parseInt(input.value);
        if (!isNaN(v)) {
            if (v > 100) input.value = 100;
            if (v < 0)   input.value = 0;
        }
    };
});
</script>
@endpush