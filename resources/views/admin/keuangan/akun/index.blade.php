@extends('layouts.main')
@section('title', 'Daftar Akun (Chart of Accounts)')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Daftar Akun Keuangan</h2>
            <p class="text-xs text-gray-500 mt-0.5">Chart of Accounts — Rekening / Pos Keuangan Pesantren</p>
        </div>
        <button onclick="document.getElementById('modalTambahAkun').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition shadow-sm w-8 h-8 flex items-center justify-center">
            <i class="fas fa-plus text-sm"></i>
        </button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded text-sm mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded text-sm mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-semibold text-gray-500 uppercase">
                    <th class="py-3 px-4 w-12">No</th>
                    <th class="py-3 px-4 w-32">Kode</th>
                    <th class="py-3 px-4">Nama Akun</th>
                    <th class="py-3 px-4 w-36">Tipe</th>
                    <th class="py-3 px-4 w-24 text-center">Status</th>
                    <th class="py-3 px-4 w-32 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($akuns as $index => $akun)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 font-mono font-semibold text-gray-700">{{ $akun->kode }}</td>
                    <td class="py-3 px-4 text-gray-800">{{ $akun->nama }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $akun->tipe_badge_color }}">
                            {{ $akun->tipe_label }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('admin.akun.toggle', $akun->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $akun->is_aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $akun->is_aktif ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-1">
                            <button onclick="openEditModal({{ $akun->id }}, '{{ addslashes($akun->kode) }}', '{{ addslashes($akun->nama) }}', '{{ $akun->tipe }}')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                Ubah
                            </button>
                            <form action="{{ route('admin.akun.destroy', $akun->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus akun ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-sm text-gray-400">
                        Belum ada data akun. Klik tombol <strong>+</strong> untuk menambah.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ====== MODAL TAMBAH AKUN ====== --}}
<div id="modalTambahAkun" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambah Akun</h3>
        <form action="{{ route('admin.akun.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Kode Akun</label>
                    <input type="text" name="kode" placeholder="contoh: 4.01.08"
                           class="w-full border-gray-300 rounded border p-2 text-sm font-mono" required>
                    <p class="text-xs text-gray-400 mt-1">Format: [tipe].[grup].[urutan] — contoh: 1.01.01, 4.01.02</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Akun</label>
                    <input type="text" name="nama" placeholder="contoh: Pendapatan Praktikum"
                           class="w-full border-gray-300 rounded border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tipe Akun</label>
                    <select name="tipe" class="w-full border-gray-300 rounded border p-2 text-sm bg-white" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="aset">Aset (Harta) — kode 1.xx.xx</option>
                        <option value="kewajiban">Kewajiban (Deposit/Hutang) — kode 2.xx.xx</option>
                        <option value="modal">Modal — kode 3.xx.xx</option>
                        <option value="pendapatan">Pendapatan — kode 4.xx.xx</option>
                        <option value="beban">Beban (Pengeluaran) — kode 5.xx.xx</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 mt-5">
                <button type="button" onclick="document.getElementById('modalTambahAkun').classList.add('hidden')"
                        class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ====== MODAL EDIT AKUN ====== --}}
<div id="modalEditAkun" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-4 rounded-lg shadow-xl p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Ubah Akun</h3>
        <form id="editAkunForm" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Kode Akun</label>
                    <input type="text" name="kode" id="editKode"
                           class="w-full border-gray-300 rounded border p-2 text-sm font-mono" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Akun</label>
                    <input type="text" name="nama" id="editNama"
                           class="w-full border-gray-300 rounded border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tipe Akun</label>
                    <select name="tipe" id="editTipe" class="w-full border-gray-300 rounded border p-2 text-sm bg-white" required>
                        <option value="aset">Aset (Harta)</option>
                        <option value="kewajiban">Kewajiban (Deposit/Hutang)</option>
                        <option value="modal">Modal</option>
                        <option value="pendapatan">Pendapatan</option>
                        <option value="beban">Beban (Pengeluaran)</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t pt-4 mt-5">
                <button type="button" onclick="document.getElementById('modalEditAkun').classList.add('hidden')"
                        class="bg-gray-500 text-white px-4 py-2 rounded text-sm">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(id, kode, nama, tipe) {
        document.getElementById('editAkunForm').action = `/akun/${id}`;
        document.getElementById('editKode').value  = kode;
        document.getElementById('editNama').value  = nama;
        document.getElementById('editTipe').value  = tipe;
        document.getElementById('modalEditAkun').classList.remove('hidden');
    }
</script>
@endpush
@endsection
