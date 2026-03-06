<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController\KbmController;

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