@extends('layouts.main')

@section('title', 'Manajemen User - eduSantri')

@section('content')

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Manajemen User</h1>
        <p class="text-gray-600">Kelola pengguna sistem eduSantri</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('users.export') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-200 transform hover:scale-105 flex items-center">
            <i class="fas fa-file-excel mr-2"></i>
            Export Excel
        </a>
        <a href="{{ route('users.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-200 transform hover:scale-105 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah User
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Total User</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['total'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Admin -->
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Admin</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['admin'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-shield text-xl text-red-600"></i>
            </div>
        </div>
    </div>

    <!-- Teacher -->
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Guru</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['teacher'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Staff -->
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Staff</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['staff'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tie text-xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Student -->
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Siswa</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['student'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-graduate text-xl text-purple-600"></i>
            </div>
        </div>
    </div>

    <!-- Active -->
    <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Aktif</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statistics['active'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-xl text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('users.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau telepon..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Semua Role</option>
                    @foreach(\App\Models\User::getRoles() as $key => $value)
                        <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                <a href="{{ route('users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
    <div class="flex items-center">
        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
        <p class="text-green-800 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
        <p class="text-red-800 font-medium">{{ session('error') }}</p>
    </div>
</div>
@endif

<!-- Data Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="usersTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        User
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Telepon
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Role
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4">
                        <input type="checkbox" class="user-checkbox w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="{{ $user->id }}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-{{ $user->getRoleBadgeColor() }}-500 to-{{ $user->getRoleBadgeColor() }}-600 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                {{ $user->getInitials() }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        @if($user->phone)
                            <i class="fas fa-phone text-gray-400 mr-2"></i>{{ $user->phone }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $user->getRoleBadgeColor() }}-100 text-{{ $user->getRoleBadgeColor() }}-800">
                            @if($user->isAdmin())
                                <i class="fas fa-user-shield mr-1"></i>
                            @elseif($user->isTeacher())
                                <i class="fas fa-chalkboard-teacher mr-1"></i>
                            @elseif($user->isStaff())
                                <i class="fas fa-user-tie mr-1"></i>
                            @else
                                <i class="fas fa-user-graduate mr-1"></i>
                            @endif
                            {{ $user->getRoleDisplayName() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button onclick="toggleStatus({{ $user->id }})" class="toggle-status px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full transition duration-200 {{ $user->status === 'active' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            <i class="fas {{ $user->status === 'active' ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                            <span class="status-text">{{ ucfirst($user->status) }}</span>
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800 transition duration-200" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="text-green-600 hover:text-green-800 transition duration-200" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-800 transition duration-200" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Tidak ada data user</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold">{{ $users->firstItem() }}</span> sampai <span class="font-semibold">{{ $users->lastItem() }}</span> dari <span class="font-semibold">{{ $users->total() }}</span> user
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Bulk Actions (shown when checkboxes are selected) -->
<div id="bulkActions" class="hidden fixed bottom-8 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-2xl p-4 border border-gray-200">
    <div class="flex items-center space-x-4">
        <span class="text-sm font-medium text-gray-700">
            <span id="selectedCount">0</span> user dipilih
        </span>
        <button onclick="bulkDelete()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center">
            <i class="fas fa-trash mr-2"></i>
            Hapus Terpilih
        </button>
        <button onclick="clearSelection()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200">
            Batal
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    // Select all checkboxes
    $('#selectAll').on('change', function() {
        $('.user-checkbox').prop('checked', this.checked);
        updateBulkActions();
    });

    // Individual checkbox change
    $('.user-checkbox').on('change', function() {
        updateBulkActions();
    });

    // Update bulk actions visibility
    function updateBulkActions() {
        const checkedCount = $('.user-checkbox:checked').length;
        $('#selectedCount').text(checkedCount);
        
        if (checkedCount > 0) {
            $('#bulkActions').removeClass('hidden');
        } else {
            $('#bulkActions').addClass('hidden');
        }
    }

});

// Toggle user status
function toggleStatus(userId) {
    $.ajax({
        url: `/users/${userId}/toggle-status`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan saat mengubah status');
        }
    });
}

// Delete single user
function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/users/${userId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Bulk delete users
function bulkDelete() {
    const selectedIds = $('.user-checkbox:checked').map(function() {
        return this.value;
    }).get();

    if (selectedIds.length === 0) {
        alert('Pilih minimal 1 user untuk dihapus');
        return;
    }

    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} user?`)) {
        $.ajax({
            url: '{{ route("users.bulk-delete") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ids: selectedIds
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan saat menghapus user');
            }
        });
    }
}

// Clear selection
function clearSelection() {
    $('.user-checkbox').prop('checked', false);
    $('#selectAll').prop('checked', false);
    $('#bulkActions').addClass('hidden');
}
</script>
@endpush