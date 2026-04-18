@extends('layouts.main')

@section('title', 'Dashboard - eduSantri')

@section('content')

<!-- Header Section with School Info -->
<div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-2">Pesantren Islam Al-Irsyad Tengaran 12</h1>
            <div class="flex items-center space-x-2 text-blue-100">
                <span class="text-sm">TP. 2025/2026 Semester Genap</span>
                <a href="#" class="inline-flex items-center text-sm hover:text-white transition duration-200">
                    <i class="fas fa-external-link-alt ml-1"></i>
                </a>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                <div class="text-sm text-blue-100 mb-1">Tahun Pelajaran</div>
                <div class="text-xl font-bold">2025/2026</div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card: Jumlah PTK -->
    <div class="stat-card bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Jumlah PTK</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $statistics['total_ptk'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-3xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Card: Jumlah Siswa -->
    <div class="stat-card bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Jumlah Siswa</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $statistics['total_siswa'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-3xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Card: Jumlah Rombel -->
    <div class="stat-card bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Jumlah Rombel</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $statistics['total_rombel'] }}</h3>
            </div>
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-layer-group text-3xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Chart 1: Presensi Masuk Sekolah -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Presensi Masuk Sekolah (7 Hari Terbaru)</h3>
            <button class="text-blue-600 hover:text-blue-700 transition duration-200">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="chart-container">
            <canvas id="presensiMasukChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Aktifitas Pengasuhan -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Aktifitas Pengasuhan 7 Hari Terbaru</h3>
            <button class="text-blue-600 hover:text-blue-700 transition duration-200">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="chart-container">
            <canvas id="aktifitasPengasuhanChart"></canvas>
        </div>
    </div>
</div>

<!-- Bottom Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Chart 3: Presensi Pengasuhan -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Presensi Pengasuhan (7 Hari Terbaru)</h3>
            <button class="text-blue-600 hover:text-blue-700 transition duration-200">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="chart-container">
            <canvas id="presensiPengasuhanChart"></canvas>
        </div>
    </div>

    <!-- Chart 4: Aktifitas Klinik -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Aktifitas Klinik 7 Hari Terbaru</h3>
            <button class="text-blue-600 hover:text-blue-700 transition duration-200">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="chart-container">
            <canvas id="aktifitasKlinikChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    const rawChartData = @json($chartData);

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
    };

    // Chart Configuration
    const chartConfig = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#3b82f6',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f3f4f6',
                    drawBorder: false
                },
                ticks: {
                    color: '#6b7280',
                    font: {
                        size: 11
                    }
                }
            },
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    color: '#6b7280',
                    font: {
                        size: 11
                    }
                }
            }
        }
    };

    // Chart 1: Presensi Masuk Sekolah
    const ctx1 = document.getElementById('presensiMasukChart').getContext('2d');
    const gradient1 = ctx1.createLinearGradient(0, 0, 0, 300);
    gradient1.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
    gradient1.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: rawChartData.presensi_masuk.map(item => formatDate(item.tanggal)),
            datasets: [{
                label: 'Jumlah',
                data: rawChartData.presensi_masuk.map(item => item.jumlah),
                borderColor: '#3b82f6',
                backgroundColor: gradient1,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: chartConfig
    });

    // Chart 2: Aktifitas Pengasuhan
    const ctx2 = document.getElementById('aktifitasPengasuhanChart').getContext('2d');
    const gradient2 = ctx2.createLinearGradient(0, 0, 0, 300);
    gradient2.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
    gradient2.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: rawChartData.aktifitas_pengasuhan.map(item => formatDate(item.tanggal)),
            datasets: [{
                label: 'Jumlah Aktifitas',
                data: rawChartData.aktifitas_pengasuhan.map(item => item.jumlah),
                borderColor: '#3b82f6',
                backgroundColor: gradient2,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: chartConfig
    });

    // Chart 3: Presensi Pengasuhan
    const ctx3 = document.getElementById('presensiPengasuhanChart').getContext('2d');
    const gradient3 = ctx3.createLinearGradient(0, 0, 0, 300);
    gradient3.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
    gradient3.addColorStop(1, 'rgba(34, 197, 94, 0.05)');

    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: rawChartData.presensi_pengasuhan.map(item => formatDate(item.tanggal)),
            datasets: [{
                label: 'Jumlah',
                data: rawChartData.presensi_pengasuhan.map(item => item.jumlah),
                borderColor: '#22c55e',
                backgroundColor: gradient3,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#22c55e',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: chartConfig
    });

    // Chart 4: Aktifitas Klinik
    const ctx4 = document.getElementById('aktifitasKlinikChart').getContext('2d');

    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: rawChartData.aktifitas_klinik.map(item => formatDate(item.tanggal)),
            datasets: [{
                label: 'Jumlah',
                data: rawChartData.aktifitas_klinik.map(item => item.jumlah),
                backgroundColor: '#ef4444',
                borderRadius: 6,
                barThickness: 40
            }]
        },
        options: {
            ...chartConfig,
            scales: {
                ...chartConfig.scales,
                y: {
                    ...chartConfig.scales.y,
                    max: 1.0,
                    ticks: {
                        ...chartConfig.scales.y.ticks,
                        stepSize: 0.1
                    }
                }
            }
        }
    });

});
</script>
@endpush