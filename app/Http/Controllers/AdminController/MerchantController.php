<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\MerchantTransaction::with(['petugas', 'student'])->latest()->paginate(10);
        return view('admin.keuangan.merchant.index', compact('transactions'));
    }
}
