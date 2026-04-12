<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController\KbmController;
use App\Http\Controllers\AdminController\PengasuhanController;
use App\Http\Controllers\AdminController\HafalanController;
use App\Http\Controllers\AdminController\PelanggaranController;
use App\Http\Controllers\AdminController\KesehatanController;
use App\Http\Controllers\AdminController\EkstrakurikulerController;
use App\Http\Controllers\AdminController\SiswaController;
use App\Http\Controllers\AdminController\OrangTuaController;
use App\Http\Controllers\AdminController\HrdController;
use App\Http\Controllers\AdminController\RombonganBelajarController;
use App\Http\Controllers\AdminController\MataPelajaranController;
use App\Http\Controllers\AdminController\ItemPelanggaranController;
use App\Http\Controllers\AdminController\KelasController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // Dashboard - Accessible by all authenticated users
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/kbm',[KbmController::class,'index'])->name('kbm.index');
    Route::post('/kbm/store',[KbmController::class,'store'])->name('kbm.store');
    Route::get('/pengasuhan', [PengasuhanController::class, 'index'])->name('pengasuhan.index');
    Route::get('/hafalan', [HafalanController::class, 'index'])->name('hafalan.index');
    Route::get('/hafalan/{user_id}', [HafalanController::class, 'show'])->name('hafalan.show');
    Route::post('/hafalan/setor', [HafalanController::class, 'storeSetoran'])->name('hafalan.storeSetoran');
    Route::get('/hafalan/{user_id}/detail/{surah_id}', [HafalanController::class, 'detail'])->name('hafalan.detail');
    Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'show', 'edit']);
    Route::resource('kesehatan', KesehatanController::class);
    Route::get('kesehatan/{id}/keluar', [KesehatanController::class, 'editKeluar'])->name('kesehatan.keluar');
    Route::put('kesehatan/{id}/keluar', [KesehatanController::class, 'updateKeluar'])->name('kesehatan.updateKeluar');

    Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
    Route::get('ekstrakurikuler/{id}/kegiatan', [EkstrakurikulerController::class, 'kegiatan'])->name('ekstrakurikuler.kegiatan');
    Route::post('ekstrakurikuler/{id}/tambah-mentor', [EkstrakurikulerController::class, 'tambahMentor'])->name('ekstrakurikuler.tambahMentor');
    Route::post('ekstrakurikuler/{id}/tambah-siswa', [EkstrakurikulerController::class, 'tambahSiswa'])->name('ekstrakurikuler.tambahSiswa');

    Route::resource('siswa', SiswaController::class);

    //Kelas
    Route::resource('kelas', KelasController::class)->except(['create','show','edit']);

    //Orang tua
    Route::resource('orangtua', OrangTuaController::class);
    Route::get('orangtua/{id}/siswa', [OrangTuaController::class, 'manageSiswa'])->name('orangtua.siswa');
    Route::post('orangtua/{id}/siswa', [OrangTuaController::class, 'storeSiswa'])->name('orangtua.storeSiswa');
    Route::delete('orangtua/{id}/siswa/{student_id}', [OrangTuaController::class, 'destroySiswa'])->name('orangtua.destroySiswa');
    Route::post('orangtua/{id}/reset-password', [OrangTuaController::class, 'resetPassword'])->name('orangtua.resetPassword');

    //HRD
    Route::resource('hrd', HrdController::class);
    Route::get('hrd/{id}/subject', [HrdController::class, 'subjects'])->name('hrd.subject');
    Route::post('hrd/{id}/subject', [HrdController::class, 'storeSubject'])->name('hrd.storeSubject');
    Route::delete('hrd/{id}/subject/{subject_id}', [HrdController::class, 'destroySubject'])->name('hrd.destroySubject');
    Route::get('hrd-fingerprint', [HrdController::class, 'fingerprint'])->name('hrd.fingerprint');
    Route::post('hrd-fingerprint', [HrdController::class, 'updateFingerprint'])->name('hrd.updateFingerprint');

    Route::resource('rombongan-belajar', RombonganBelajarController::class)->except(['create','show','edit']);
    Route::resource('mata-pelajaran', MataPelajaranController::class)->except(['create','show','edit']);
    Route::resource('item-pelanggaran', ItemPelanggaranController::class)->except(['create','show','edit']);
    
    // API endpoint for chart data updates
    Route::get('/api/chart-data', [DashboardController::class, 'getChartData'])->name('api.chart-data');
    
    // User Management Routes - Only accessible by Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    });
    
    // Teacher Routes - Accessible by Admin and Teacher
    Route::middleware(['role:admin,teacher'])->group(function () {
        // Add your teacher-specific routes here
        // Example:
        // Route::resource('presensi', PresensiController::class);
        // Route::resource('nilai', NilaiController::class);
        // Route::resource('jadwal', JadwalController::class);
    });
    
    // Staff Routes - Accessible by Admin and Staff
    Route::middleware(['role:admin,staff'])->group(function () {
        // Add your staff-specific routes here
        // Example:
        // Route::resource('keuangan', KeuanganController::class);
        // Route::get('laporan/keuangan', [LaporanController::class, 'keuangan']);
    });
    
    // Student Routes - Accessible by all roles
    Route::middleware(['role:admin,teacher,staff,student'])->group(function () {
        // Add your student-accessible routes here
        // Example:
        // Route::get('nilai/my', [NilaiController::class, 'myNilai'])->name('nilai.my');
        // Route::get('jadwal/my', [JadwalController::class, 'myJadwal'])->name('jadwal.my');
    });
    
});

// 403 Forbidden page (optional)
Route::get('/forbidden', function () {
    abort(403, 'Anda tidak memiliki akses ke halaman ini.');
})->name('forbidden');