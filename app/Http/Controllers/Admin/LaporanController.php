<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'bulan_ini');
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');

        // Tentukan range tanggal
        switch ($periode) {
            case 'hari_ini':
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                break;
            case 'minggu_ini':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                break;
            case 'bulan_ini':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                break;
            case 'bulan_lalu':
                $start = now()->subMonth()->startOfMonth();
                $end = now()->subMonth()->endOfMonth();
                break;
            case 'tahun_ini':
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                break;
            case 'custom':
                $start = $dari ? \Carbon\Carbon::parse($dari)->startOfDay() : now()->startOfMonth();
                $end = $sampai ? \Carbon\Carbon::parse($sampai)->endOfDay() : now()->endOfMonth();
                break;
            default:
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
        }

        // Ringkasan
        $totalPendapatan = Pesanan::whereBetween('created_at', [$start, $end])
            ->where('status', 'selesai')
            ->sum('total_price');

        $totalPesanan = Pesanan::whereBetween('created_at', [$start, $end])->count();

        $pesananSelesai = Pesanan::whereBetween('created_at', [$start, $end])
            ->where('status', 'selesai')
            ->count();

        $pesananDibatalkan = Pesanan::whereBetween('created_at', [$start, $end])
            ->where('status', 'dibatalkan')
            ->count();

        $rataRata = $pesananSelesai > 0 ? $totalPendapatan / $pesananSelesai : 0;

        // Produk terlaris
        $produkTerlaris = $this->getProdukTerlaris($start, $end);

        // Pesanan per status
        $pesananPerStatus = Pesanan::whereBetween('created_at', [$start, $end])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        // Label periode
        $labelPeriode = $start->format('d M Y') . ' — ' . $end->format('d M Y');

        return view('admin.laporan', compact(
            'totalPendapatan', 'totalPesanan', 'pesananSelesai',
            'pesananDibatalkan', 'rataRata', 'produkTerlaris',
            'pesananPerStatus', 'periode', 'dari', 'sampai', 'labelPeriode'
        ));
    }

    public function chart(Request $request)
    {
        $tipe = $request->get('tipe', 'bulanan');
        $tahun = $request->get('tahun', now()->year);

        if ($tipe === 'bulanan') {
            $data = [];
            $labels = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = strftime('%b', mktime(0, 0, 0, $i, 1));
                $pendapatan = Pesanan::whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $i)
                    ->where('status', 'selesai')
                    ->sum('total_price');
                $pesanan = Pesanan::whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $i)
                    ->count();
                $data[] = [
                    'pendapatan' => (float) $pendapatan,
                    'pesanan' => (int) $pesanan,
                ];
            }
        } else {
            // Harian (30 hari terakhir)
            $data = [];
            $labels = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->format('d M');
                $pendapatan = Pesanan::whereDate('created_at', $date)
                    ->where('status', 'selesai')
                    ->sum('total_price');
                $pesanan = Pesanan::whereDate('created_at', $date)->count();
                $data[] = [
                    'pendapatan' => (float) $pendapatan,
                    'pesanan' => (int) $pesanan,
                ];
            }
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    private function getProdukTerlaris($start, $end)
    {
        $pesanans = Pesanan::whereBetween('created_at', [$start, $end])
            ->where('status', 'selesai')
            ->whereNotNull('items')
            ->get();

        $produkMap = [];
        foreach ($pesanans as $pesanan) {
            $items = is_string($pesanan->items) ? json_decode($pesanan->items, true) : $pesanan->items;
            if (is_array($items)) {
                foreach ($items as $item) {
                    $name = $item['name'] ?? 'Tidak diketahui';
                    if (!isset($produkMap[$name])) {
                        $produkMap[$name] = ['name' => $name, 'qty' => 0, 'revenue' => 0];
                    }
                    $qty = $item['qty'] ?? 1;
                    $price = $item['price'] ?? 0;
                    $produkMap[$name]['qty'] += $qty;
                    $produkMap[$name]['revenue'] += $qty * $price;
                }
            }
        }

        usort($produkMap, function ($a, $b) {
            return $b['qty'] - $a['qty'];
        });

        return array_slice($produkMap, 0, 10);
    }
}