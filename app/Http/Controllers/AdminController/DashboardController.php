<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Example: Get statistics from database
        $statistics = [
            'total_ptk' => $this->getTotalPTK(),
            'total_siswa' => $this->getTotalSiswa(),
            'total_rombel' => $this->getTotalRombel(),
        ];

        // Example: Get chart data
        $chartData = [
            'presensi_masuk' => $this->getPresensiMasukData(),
            'aktifitas_pengasuhan' => $this->getAktifitasPengasuhanData(),
            'presensi_pengasuhan' => $this->getPresensiPengasuhanData(),
            'aktifitas_klinik' => $this->getAktifitasKlinikData(),
        ];

        return view('admin.index', compact('statistics', 'chartData'));
    }

    /**
     * Get total PTK (Pendidik dan Tenaga Kependidikan)
     */
    private function getTotalPTK()
    {
        // Replace with your actual query
        // return DB::table('ptk')->count();
        return 31;
    }

    /**
     * Get total students
     */
    private function getTotalSiswa()
    {
        // Replace with your actual query
        // return DB::table('siswa')->count();
        return 34;
    }

    /**
     * Get total rombel (Rombongan Belajar)
     */
    private function getTotalRombel()
    {
        // Replace with your actual query
        // return DB::table('rombel')->count();
        return 2;
    }

    /**
     * Get presensi masuk data for chart
     */
    private function getPresensiMasukData()
    {
        // Replace with your actual query
        // Example:
        // return DB::table('presensi')
        //     ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as jumlah'))
        //     ->where('created_at', '>=', now()->subDays(7))
        //     ->groupBy('tanggal')
        //     ->orderBy('tanggal', 'desc')
        //     ->get();

        return [
            ['tanggal' => '2025-01-17', 'jumlah' => 8],
            ['tanggal' => '2025-01-16', 'jumlah' => 30],
            ['tanggal' => '2025-01-15', 'jumlah' => 31],
            ['tanggal' => '2025-01-14', 'jumlah' => 31],
            ['tanggal' => '2025-01-13', 'jumlah' => 31],
            ['tanggal' => '2025-01-12', 'jumlah' => 30],
            ['tanggal' => '2025-01-11', 'jumlah' => 15],
        ];
    }

    /**
     * Get aktifitas pengasuhan data for chart
     */
    private function getAktifitasPengasuhanData()
    {
        // Replace with your actual query
        return [
            ['tanggal' => '2025-01-17', 'jumlah' => 0],
            ['tanggal' => '2025-01-15', 'jumlah' => 80],
            ['tanggal' => '2025-01-08', 'jumlah' => 80],
            ['tanggal' => '2025-01-06', 'jumlah' => 0],
            ['tanggal' => '2024-12-19', 'jumlah' => 0],
            ['tanggal' => '2024-12-18', 'jumlah' => 0],
            ['tanggal' => '2024-12-14', 'jumlah' => 110],
        ];
    }

    /**
     * Get presensi pengasuhan data for chart
     */
    private function getPresensiPengasuhanData()
    {
        // Replace with your actual query
        return [
            ['tanggal' => '2025-01-17', 'jumlah' => 2],
            ['tanggal' => '2025-01-16', 'jumlah' => 25],
            ['tanggal' => '2025-01-15', 'jumlah' => 29],
            ['tanggal' => '2025-01-14', 'jumlah' => 29],
            ['tanggal' => '2025-01-13', 'jumlah' => 28],
            ['tanggal' => '2025-01-12', 'jumlah' => 29],
            ['tanggal' => '2025-01-11', 'jumlah' => 29],
        ];
    }

    /**
     * Get aktifitas klinik data for chart
     */
    private function getAktifitasKlinikData()
    {
        // Replace with your actual query
        return [
            ['tanggal' => '2025-01-17', 'jumlah' => 0],
            ['tanggal' => '2025-01-16', 'jumlah' => 0],
            ['tanggal' => '2025-01-15', 'jumlah' => 0],
            ['tanggal' => '2025-01-14', 'jumlah' => 0],
            ['tanggal' => '2025-01-13', 'jumlah' => 0],
            ['tanggal' => '2025-01-12', 'jumlah' => 0],
            ['tanggal' => '2025-01-11', 'jumlah' => 0],
        ];
    }

    /**
     * API endpoint to get fresh chart data (for AJAX updates)
     */
    public function getChartData(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case 'presensi_masuk':
                $data = $this->getPresensiMasukData();
                break;
            case 'aktifitas_pengasuhan':
                $data = $this->getAktifitasPengasuhanData();
                break;
            case 'presensi_pengasuhan':
                $data = $this->getPresensiPengasuhanData();
                break;
            case 'aktifitas_klinik':
                $data = $this->getAktifitasKlinikData();
                break;
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}