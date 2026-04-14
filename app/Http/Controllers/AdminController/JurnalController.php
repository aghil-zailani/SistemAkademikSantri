<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\JurnalItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    private $akunOptions = [
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

    private $bulanList = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));

        $jurnals = Jurnal::with(['items', 'user'])
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderByDesc('tanggal')
            ->paginate(20);

        return view('admin.keuangan.jurnal.index', [
            'jurnals'    => $jurnals,
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'bulanList'  => $this->bulanList,
        ]);
    }

    public function create()
    {
        return view('admin.keuangan.jurnal.create', [
            'akunOptions' => $this->akunOptions,
            'now'         => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'akun'    => 'required|array|min:1',
            'akun.*'  => 'required|string',
            'posisi'  => 'required|array',
            'posisi.*'=> 'required|in:debit,credit',
            'nominal' => 'required|array',
            'nominal.*' => 'required|numeric|min:0',
        ]);

        $jurnal = Jurnal::create([
            'user_id' => Auth::id(),
            'tanggal' => Carbon::now(),
        ]);

        foreach ($request->akun as $i => $akun) {
            if (empty($akun) || empty($request->nominal[$i])) continue;

            JurnalItem::create([
                'jurnal_id' => $jurnal->id,
                'akun'      => $akun,
                'posisi'    => $request->posisi[$i],
                'nominal'   => $request->nominal[$i],
                'catatan'   => $request->catatan[$i] ?? null,
            ]);
        }

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    public function destroy($id)
    {
        Jurnal::findOrFail($id)->delete(); // items cascade deleted
        return back()->with('success', 'Jurnal berhasil dihapus.');
    }
}
