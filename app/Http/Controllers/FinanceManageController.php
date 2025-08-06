<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;

class FinanceManageController extends Controller
{
    public function index()
    {
        $finances = Finance::orderBy('tanggal', 'desc')->get();

        $total_pemasukan = Finance::where('jenis', 'pemasukan')->sum('jumlah');
        $total_pengeluaran = Finance::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $total_pemasukan - $total_pengeluaran;

        return view('finance.index', compact('finances', 'total_pemasukan', 'total_pengeluaran', 'saldo'));
    }
}
