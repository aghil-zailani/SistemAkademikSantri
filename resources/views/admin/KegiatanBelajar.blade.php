@extends('layouts.main')

@section('title', 'KBM - eduSantri')

@section('content')

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kegiatan Belajar Mengajar</h1>
            <p class="text-gray-600">Kelola dan pantau kegiatan belajar mengajar di pesantren</p>
        </div>
        <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-200 transform hover:scale-105 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah KBM
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total KBM -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 transform transition duration-200 hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Total KBM</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $kbms->count() }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-book-reader text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- KBM Selesai -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 transform transition duration-200 hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Selesai</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $kbms->where('status', 'selesai')->count() }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- KBM Belum Selesai -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 transform transition duration-200 hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Belum Selesai</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $kbms->where('status', 'belum_selesai')->count() }}</h3>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-2xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <!-- KBM Hari Ini -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 transform transition duration-200 hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Hari Ini</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $kbms->where('tanggal', date('Y-m-d'))->count() }}</h3>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-day text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari KBM</label>
            <div class="relative">
                <input type="text" id="searchKBM" placeholder="Cari guru, kelas, atau mapel..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
            <select id="filterKelas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <option value="">Semua Kelas</option>
                @foreach($kelas as $k)
                <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select id="filterStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <option value="">Semua Status</option>
                <option value="selesai">Selesai</option>
                <option value="belum_selesai">Belum Selesai</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
            <input type="date" id="filterTanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        </div>
        <div class="flex items-end space-x-2">
            <button onclick="applyFilter()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
            <button onclick="resetFilter()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200">
                <i class="fas fa-redo"></i>
            </button>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6 overflow-x-auto">
        <table id="kbmTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-calendar mr-2"></i>Tanggal
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-user-tie mr-2"></i>Guru
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-school mr-2"></i>Kelas
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-book mr-2"></i>Mata Pelajaran
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-clipboard mr-2"></i>Materi
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-info-circle mr-2"></i>Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-cog mr-2"></i>Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($kbms as $kbm)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-lg px-3 py-2 text-center">
                                <div class="text-xs font-medium text-blue-600">{{ \Carbon\Carbon::parse($kbm->tanggal)->format('M') }}</div>
                                <div class="text-lg font-bold text-blue-800">{{ \Carbon\Carbon::parse($kbm->tanggal)->format('d') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                {{ strtoupper(substr($kbm->guru->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $kbm->guru->name }}</div>
                                <div class="text-xs text-gray-500">Guru Pengajar</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            <i class="fas fa-users mr-1"></i>
                            {{ $kbm->kelas->nama_kelas }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $kbm->mataPelajaran->nama_mata_pelajaran }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $kbm->materi }}">
                            {{ $kbm->materi }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($kbm->status == 'selesai')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Selesai
                        </span>
                        @else
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>
                            Belum Selesai
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <button onclick="viewDetail({{ $kbm->id }})" class="text-blue-600 hover:text-blue-800 transition duration-200" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="editKBM({{ $kbm->id }})" class="text-green-600 hover:text-green-800 transition duration-200" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteKBM({{ $kbm->id }})" class="text-red-600 hover:text-red-800 transition duration-200" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-book-reader text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Tidak ada data KBM</p>
                            <button onclick="openModal()" class="mt-4 text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah KBM Pertama
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah KBM -->
<div id="kbmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-2xl flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                    <i class="fas fa-book-reader text-white text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Tambah Kegiatan Belajar Mengajar</h2>
            </div>
            <button onclick="closeModal()" class="text-white hover:text-red-200 transition duration-200 text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form action="{{ route('kbm.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Informasi Dasar -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-calendar text-gray-500 mr-1"></i>Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-clock text-gray-500 mr-1"></i>Jam Pembelajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="jam_pembelajaran" required placeholder="Contoh: 08:00 - 10:00" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Informasi Kelas & Mapel -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-school text-blue-600 mr-2"></i>
                    Kelas & Mata Pelajaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-users text-gray-500 mr-1"></i>Kelas <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-book text-gray-500 mr-1"></i>Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="mata_pelajaran_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mapel as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Materi Pembelajaran -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
                    Materi Pembelajaran
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-file-alt text-gray-500 mr-1"></i>Materi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="materi" required rows="3" placeholder="Masukkan materi yang diajarkan..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-list text-gray-500 mr-1"></i>Sub Materi
                        </label>
                        <textarea name="sub_materi" rows="2" placeholder="Masukkan sub materi (opsional)..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
                    </div>
                </div>
            </div>

            <!-- Metode Pembelajaran -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i>
                    Metode Pembelajaran
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input type="checkbox" name="metode_pembelajaran[]" value="ceramah" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 group-hover:text-blue-600 transition duration-200">
                            <i class="fas fa-comments mr-1"></i>Ceramah
                        </span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input type="checkbox" name="metode_pembelajaran[]" value="diskusi" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 group-hover:text-blue-600 transition duration-200">
                            <i class="fas fa-users mr-1"></i>Diskusi
                        </span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input type="checkbox" name="metode_pembelajaran[]" value="tanya_jawab" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 group-hover:text-blue-600 transition duration-200">
                            <i class="fas fa-question-circle mr-1"></i>Tanya Jawab
                        </span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input type="checkbox" name="metode_pembelajaran[]" value="praktek" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 group-hover:text-blue-600 transition duration-200">
                            <i class="fas fa-hands mr-1"></i>Praktek
                        </span>
                    </label>
                </div>
            </div>

            <!-- Status & Catatan -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-tasks text-blue-600 mr-2"></i>
                    Status & Catatan
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-check-circle text-gray-500 mr-1"></i>Status Pembelajaran <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="status" value="selesai" required class="w-4 h-4 text-green-600 focus:ring-green-500">
                                <span class="text-sm font-medium text-gray-700">
                                    <i class="fas fa-check text-green-600 mr-1"></i>Selesai
                                </span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="status" value="belum_selesai" required class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                                <span class="text-sm font-medium text-gray-700">
                                    <i class="fas fa-clock text-yellow-600 mr-1"></i>Belum Selesai
                                </span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-sticky-note text-gray-500 mr-1"></i>Catatan / Kejadian Penting
                        </label>
                        <textarea name="catatan" rows="3" placeholder="Masukkan catatan atau kejadian penting selama pembelajaran..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>
                    Simpan KBM
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#kbmTable').DataTable({
        pageLength: 10,
        ordering: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            zeroRecords: "Tidak ada data yang ditemukan",
            emptyTable: "Tidak ada data KBM"
        },
        columnDefs: [
            { orderable: false, targets: -1 } // Disable sorting on action column
        ]
    });
});

// Modal functions
function openModal() {
    document.getElementById('kbmModal').classList.remove('hidden');
    document.getElementById('kbmModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('kbmModal').classList.add('hidden');
    document.getElementById('kbmModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Filter functions
function applyFilter() {
    const table = $('#kbmTable').DataTable();
    
    // Get filter values
    const searchValue = document.getElementById('searchKBM').value;
    const kelasValue = document.getElementById('filterKelas').value;
    const statusValue = document.getElementById('filterStatus').value;
    const tanggalValue = document.getElementById('filterTanggal').value;
    
    // Apply search
    table.search(searchValue).draw();
    
    // Apply custom filters
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            const kelas = data[2] || ''; // Kelas column
            const status = data[5] || ''; // Status column
            const tanggal = data[0] || ''; // Tanggal column
            
            let kelasMatch = !kelasValue || kelas.includes(kelasValue);
            let statusMatch = !statusValue || status.toLowerCase().includes(statusValue.toLowerCase());
            let tanggalMatch = !tanggalValue || tanggal.includes(tanggalValue);
            
            return kelasMatch && statusMatch && tanggalMatch;
        }
    );
    
    table.draw();
}

function resetFilter() {
    document.getElementById('searchKBM').value = '';
    document.getElementById('filterKelas').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterTanggal').value = '';
    
    $.fn.dataTable.ext.search.pop();
    $('#kbmTable').DataTable().search('').draw();
}

// CRUD functions
function viewDetail(id) {
    // Add your view detail logic here
    alert('View detail KBM ID: ' + id);
}

function editKBM(id) {
    // Add your edit logic here
    alert('Edit KBM ID: ' + id);
}

function deleteKBM(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data KBM ini?')) {
        // Add your delete logic here
        alert('Delete KBM ID: ' + id);
    }
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Close modal on outside click
document.getElementById('kbmModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeModal();
    }
});
</script>
@endpush