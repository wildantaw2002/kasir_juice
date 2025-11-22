<?php

namespace App\Http\Controllers;

use App\Models\t_menu;
use App\Models\m_transaksi;
use App\Models\t_detail_transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika kasir, redirect ke halaman kasir
        if (auth()->user()->role === 'kasir') {
            return redirect()->route('kasir.index');
        }

        // Statistik untuk admin
        $totalMenu = t_menu::count();
        $totalTransaksi = m_transaksi::count();
        $totalPendapatan = m_transaksi::sum('total') ?? 0;
        $totalKasir = User::where('role', 'kasir')->count();

        // Transaksi hari ini
        $transaksiHariIni = m_transaksi::whereDate('time', today())->count();
        $pendapatanHariIni = m_transaksi::whereDate('time', today())->sum('total') ?? 0;

        // Menu terlaris (top 5)
        $menuTerlaris = t_detail_transaksi::select('id_menu', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('id_menu')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->with('menu')
            ->get();

        // Transaksi terakhir
        $transaksiTerakhir = m_transaksi::with(['user', 'details.menu'])
            ->latest('time')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalMenu',
            'totalTransaksi',
            'totalPendapatan',
            'totalKasir',
            'transaksiHariIni',
            'pendapatanHariIni',
            'menuTerlaris',
            'transaksiTerakhir'
        ));
    }
}
