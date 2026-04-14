<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuBesar;

class BukuBesarController extends Controller
{
    private $akunList = [
        '1.01.01 - Kas Kecil',
        '1.01.02 - Bank BSI (PIAT12)',
        '2.01.01 - Deposit Siswa',
        '2.01.02 - Deposit SPP',
        '2.01.03 - Deposit Air Mart',
        '2.01.04 - Deposit Kantin',
        '2.01.05 - Deposit Laundry',
        '2.01.06 - Deposit Seragam',
        '4.01.01 - Pendapatan Air Mart',
        '4.01.02 - Pendapatan Kantin',
        '4.01.04 - Pendapatan SPP',
    ];

    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));

        // Build summary per akun for the selected month/year
        $summary = collect($this->akunList)->map(function ($akun) use ($bulan, $tahun) {
            $rows = BukuBesar::where('akun', $akun)
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->orderBy('tanggal')
                ->get();

            $open   = $rows->first()->open ?? 0;
            $debit  = $rows->sum('debit');
            $credit = $rows->sum('credit');
            $close  = $rows->last()->close ?? 0;

            return [
                'akun'   => $akun,
                'open'   => $open,
                'debit'  => $debit,
                'credit' => $credit,
                'close'  => $close,
                'has_data' => $rows->count() > 0,
            ];
        });

        $totalDebit  = $summary->sum('debit');
        $totalCredit = $summary->sum('credit');

        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('admin.keuangan.buku_besar.index', compact(
            'summary', 'totalDebit', 'totalCredit', 'bulan', 'tahun', 'bulanList'
        ));
    }

    public function show(Request $request, $akun)
    {
        $akunDecoded = urldecode($akun);
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));

        $rows = BukuBesar::where('akun', $akunDecoded)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->paginate(10);

        $summary = BukuBesar::where('akun', $akunDecoded)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->get();

        $open   = $summary->first()->open ?? 0;
        $debit  = $summary->sum('debit');
        $credit = $summary->sum('credit');
        $close  = $summary->last()->close ?? 0;

        return view('admin.keuangan.buku_besar.show', compact(
            'akunDecoded', 'rows', 'bulan', 'tahun', 'open', 'debit', 'credit', 'close'
        ));
    }
}
