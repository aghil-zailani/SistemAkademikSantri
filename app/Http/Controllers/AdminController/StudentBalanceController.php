<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentBalanceController extends Controller
{
    public function index()
    {
        $balances = \App\Models\StudentBalance::with('student')->paginate(10);
        $totalBalance = \App\Models\StudentBalance::sum('saldo');
        return view('admin.keuangan.student_balance.index', compact('balances', 'totalBalance'));
    }

    public function show($id)
    {
        $balance = \App\Models\StudentBalance::with('student')->where('student_id', $id)->firstOrFail();
        $transactions = \App\Models\StudentBalanceTransaction::where('student_id', $id)->latest()->paginate(10);
        return view('admin.keuangan.student_balance.show', compact('balance', 'transactions'));
    }
}
