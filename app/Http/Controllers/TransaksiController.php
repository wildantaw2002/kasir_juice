<?php

namespace App\Http\Controllers;

use App\Models\t_menu;
use App\Models\m_transaksi;
use App\Models\t_detail_transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    /**
     * Tampilkan halaman kasir (POS)
     */
    public function index(Request $request)
    {
        $query = t_menu::query();

        // Search menu
        if ($request->has('search')) {
            $query->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $menus = $query->get();
        $kategoris = t_menu::distinct()->pluck('kategori');

        return view('kasir.index', compact('menus', 'kategoris'));
    }

    /**
     * Simpan transaksi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_menu' => 'required|exists:t_menu,id',
            'items.*.ukuran' => 'required|in:Small,Medium,Large',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_bayar' => 'required|in:Cash,Debit,QRIS',
        ]);

        DB::beginTransaction();
        try {
            // Generate kode transaksi unik dan berurutan
            $today = date('Ymd');
            $prefix = 'TRX-' . $today . '-';
            
            // Ambil transaksi terakhir hari ini
            $lastTrx = m_transaksi::where('kode_transaksi', 'like', $prefix . '%')
                ->orderBy('id', 'desc')
                ->first();
            
            if ($lastTrx) {
                // Ambil nomor urut terakhir dan increment
                $lastNumber = (int) substr($lastTrx->kode_transaksi, -3);
                $newNumber = $lastNumber + 1;
            } else {
                // Transaksi pertama hari ini
                $newNumber = 1;
            }
            
            $kode = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // Simpan transaksi
            $transaksi = m_transaksi::create([
                'kode_transaksi' => $kode,
                'id_user' => auth()->id(),
                'total' => $validated['total'],
                'metode_bayar' => $validated['metode_bayar'],
                'time' => now(),
            ]);

            // Simpan detail transaksi
            foreach ($validated['items'] as $item) {
                t_detail_transaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_menu' => $item['id_menu'],
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan!',
                'kode_transaksi' => $kode,
                'transaksi_id' => $transaksi->id,
                'total' => $validated['total'],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan riwayat transaksi
     */
    public function history()
    {
        $transaksis = m_transaksi::with(['user', 'details.menu'])
            ->where('id_user', auth()->id())
            ->latest()
            ->paginate(10);

        return view('kasir.history', compact('transaksis'));
    }

    /**
     * Detail transaksi
     */
    public function show($id)
    {
        $transaksi = m_transaksi::with(['user', 'details.menu'])
            ->findOrFail($id);

        // Pastikan hanya bisa lihat transaksi sendiri (kecuali admin)
        if (auth()->user()->role != 'admin' && $transaksi->id_user != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('kasir.detail', compact('transaksi'));
    }

    /**
     * Print struk PDF
     */
    public function printPDF($id)
    {
        $transaksi = m_transaksi::with(['user', 'details.menu'])
            ->findOrFail($id);

        // Pastikan hanya bisa print transaksi sendiri (kecuali admin)
        if (auth()->user()->role != 'admin' && $transaksi->id_user != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load view dan convert ke PDF
        $pdf = Pdf::loadView('kasir.print', compact('transaksi'))
            ->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm width thermal paper

        // Download PDF
        return $pdf->download('Struk-' . $transaksi->kode_transaksi . '.pdf');
    }
}
