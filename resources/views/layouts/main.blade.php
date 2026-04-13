<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'eduSantri - Dashboard')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Dropdown hover effect */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Chart container */
        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Card hover effect */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px);
            transition: all .15s ease;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    
    <!-- Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left side - Logo and Navigation -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-blue-600">eduSantri</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                        
                        <!-- Dropdown: Aktifitas -->
                        <div class="relative dropdown">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-chart-line mr-2"></i>Aktifitas
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div class="dropdown-menu absolute left-0 top-full w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                <a href="{{ route('kbm.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-chalkboard-user mr-2"></i>KBM Saya
                                </a>
                                <a href="{{ route('pengasuhan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-hands-holding-child mr-2"></i>Pengasuhan
                                </a>
                                <a href="{{ route('hafalan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-book-quran mr-2"></i>Hafalan Siswa
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-clipboard-check mr-2"></i>Penilaian
                                </a>
                                <a href="{{ route('pelanggaran.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-triangle-exclamation mr-2"></i>Pelanggaran
                                </a>
                                <a href="{{ route('kesehatan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-notes-medical mr-2"></i>Kesehatan Siswa
                                </a>
                                <a href="{{ route('ekstrakurikuler.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-futbol mr-2"></i>Ekstrakurikuler
                                </a>
                            </div>
                        </div>

                        <!-- Dropdown: Data Pokok -->
                        <div class="relative dropdown">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-database mr-2"></i>Data Pokok
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div class="dropdown-menu absolute left-0 top-full w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                <a href="{{ route('siswa.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-graduate mr-2"></i>Siswa
                                </a>
                                <a href="{{ route('orangtua.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-people-roof mr-2"></i>Orang Tua
                                </a>
                                <a href="{{ route('hrd.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-tie mr-2"></i>HRD
                                </a>
                                <!-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-calendar-alt mr-2"></i>HRD Fingerprint
                                </a> -->
                                <div class="relative group">
                                    <div class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 cursor-pointer">
                                        <span><i class="fas fa-folder-tree mr-2"></i>Referensi</span>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </div>

                                    <div class="absolute left-full top-0 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                                        <a href="{{ route('kelas.index') }}" class="block px-4 py-2 text-sm hover:bg-blue-50">Kelas</a>
                                        <a href="{{ route('rombongan-belajar.index') }}" class="block px-4 py-2 text-sm hover:bg-blue-50">Rombongan Belajar</a>
                                        <a href="{{ route('mata-pelajaran.index') }}" class="block px-4 py-2 text-sm hover:bg-blue-50">Mata Pelajaran</a>
                                        <a href="{{ route('item-pelanggaran.index') }}" class="block px-4 py-2 text-sm hover:bg-blue-50">Item Pelanggaran</a>
                                        <!-- <a href="#" class="block px-4 py-2 text-sm hover:bg-blue-50">Konfirmasi Kartu</a>
                                        <a href="#" class="block px-4 py-2 text-sm hover:bg-blue-50">Nama Photo</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown: Keuangan -->
                        <div class="relative dropdown">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-wallet mr-2"></i>Keuangan
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div class="dropdown-menu absolute left-0 top-full w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                <a href="{{ route('merchant.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-store mr-2"></i>Uang Masuk (Merchant)
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-building-columns mr-2"></i>Uang Masuk (VA)
                                </a>
                                <a href="{{ route('uang-siswa.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-wallet mr-2"></i>Uang Siswa
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-file-invoice-dollar mr-2"></i>Tagihan
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-book mr-2"></i>Buku Besar
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-pen-to-square mr-2"></i>Jurnal
                                </a>
                            </div>
                        </div>

                        <!-- Dropdown: Laporan -->
                        <div class="relative dropdown">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>Laporan
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div class="dropdown-menu absolute left-0 top-full w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-check mr-2"></i>Presensi Siswa
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-chalkboard mr-2"></i>Laporan KBM
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-person-chalkboard mr-2"></i>Aktivitas Guru
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-clock mr-2"></i>Laporan Presensi Siswa
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user-clock mr-2"></i>Laporan Presensi Guru
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-brain mr-2"></i>Kepribadian Siswa
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-chart-line mr-2"></i>Rekapitulasi Nilai
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-file-lines mr-2"></i>Rapor Siswa
                                </a>
                            </div>
                        </div>

                        <!-- Dropdown: Pengaturan -->
                        <div class="relative dropdown">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-cog mr-2"></i>Pengaturan
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                            <div class="dropdown-menu absolute left-0 top-full w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-layer-group mr-2"></i>Rombongan Belajar
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-calendar-days mr-2"></i>Jadwal Presensi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side - User Profile -->
                <div class="flex items-center">
                    <div class="relative dropdown">
                        <button class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="text-left hidden md:block">
                                <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Ade Eka Saputra' }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 top-full w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                <i class="fas fa-user mr-2"></i>Profil Saya
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                <i class="fas fa-key mr-2"></i>Ubah Password
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-sm text-gray-500">
                © {{ date('Y') }} eduSantri. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>