<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // ============================================================
    //  ALUR STATUS YANG VALID
    // ============================================================
    private const FLOW = [
        'masuk'         => ['dikonfirmasi', 'dibatalkan'],
        'dikonfirmasi'  => ['dikemas'],
        'dikemas'       => ['dikirim'],
        'dikirim'       => ['diperjalanan'],
        'diperjalanan'  => ['selesai'],
    ];

    // ============================================================
    //  HELPER: ambil data pesanan berdasarkan status
    // ============================================================
    private function getByStatus(string $status, Request $request)
    {
        $query = Pesanan::where('status', $status);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('code', 'LIKE', "%{$s}%")
                  ->orWhere('customer_name', 'LIKE', "%{$s}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$s}%");
            });
        }

        return $query->orderBy('created_at', 'desc')
                     ->paginate($request->per_page ?? 10);
    }

    // ============================================================
    //  HALAMAN LIST
    // ============================================================
    public function masuk(Request $request)
    {
        $pesanan = $this->getByStatus('masuk', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))
            ->with('pageTitle', 'Pesanan Masuk')
            ->with('statusKey', 'masuk');
    }

    public function dikonfirmasi(Request $request)
    {
        $pesanan = $this->getByStatus('dikonfirmasi', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))
            ->with('pageTitle', 'Pesanan Dikonfirmasi')
            ->with('statusKey', 'dikonfirmasi');
    }

    public function dikemas(Request $request)
    {
        $pesanan = $this->getByStatus('dikemas', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))
            ->with('pageTitle', 'Pesanan Dikemas')
            ->with('statusKey', 'dikemas');
    }

    public function dikirim(Request $request)
    {
        $pesanan = $this->getByStatus('dikirim', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))
            ->with('pageTitle', 'Pesanan Dikirim')
            ->with('statusKey', 'dikirim');
    }

    public function diperjalanan(Request $request)
    {
        $pesanan = $this->getByStatus('diperjalanan', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))
            ->with('pageTitle', 'Pesanan Dalam Perjalanan')
            ->with('statusKey', 'diperjalanan');
    }

    public function selesai(Request $request)
    {
        $pesanan = $this->getByStatus('selesai', $request);
        return view('admin.pesanan.masuk', compact('pesanan'))
            ->with('pageTitle', 'Pesanan Selesai')
            ->with('statusKey', 'selesai');
    }

    public function dibatalkan(Request $request)
    {
        $pesanan = $this->getByStatus('dibatalkan', $request);
        return view('admin.pembatalan', compact('pesanan'))
            ->with('pageTitle', 'Pembatalan')
            ->with('statusKey', 'dibatalkan');
    }

    public function pengembalian(Request $request)
    {
        $pesanan = Pesanan::where('status', 'selesai')
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where('code', 'LIKE', "%{$s}%")
                  ->orWhere('customer_name', 'LIKE', "%{$s}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$s}%");
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return view('admin.pengembalian', compact('pesanan'))
            ->with('pageTitle', 'Pengembalian')
            ->with('statusKey', 'pengembalian');
    }

    // ============================================================
    //  DETAIL PESANAN
    // ============================================================
    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    // ============================================================
    //  AKSI UBAH STATUS
    // ============================================================
    private function ubahStatus(Request $request, $id, string $nextStatus)
    {
        $pesanan = Pesanan::findOrFail($id);
        $current = $pesanan->status;

        $allowed = self::FLOW[$current] ?? [];
        if (!in_array($nextStatus, $allowed)) {
            return back()->with('error', "Gagal: status '{$current}' tidak bisa diubah ke '{$nextStatus}'");
        }

        DB::beginTransaction();
        try {
            $pesanan->update(['status' => $nextStatus]);
            DB::commit();

            $routeName = 'admin.pesanan.' . $nextStatus;
            return redirect()->route($routeName)
                ->with('success', "Pesanan {$pesanan->code} berhasil diubah ke '{$nextStatus}'");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function aksiKonfirmasi(Request $request, $id)
    {
        return $this->ubahStatus($request, $id, 'dikonfirmasi');
    }

    public function aksiDikemas(Request $request, $id)
    {
        return $this->ubahStatus($request, $id, 'dikemas');
    }

    public function aksiDikirim(Request $request, $id)
    {
        return $this->ubahStatus($request, $id, 'dikirim');
    }

    public function aksiDiperjalanan(Request $request, $id)
    {
        return $this->ubahStatus($request, $id, 'diperjalanan');
    }

    public function aksiSelesai(Request $request, $id)
    {
        return $this->ubahStatus($request, $id, 'selesai');
    }

    public function aksiDibatalkan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'masuk') {
            return back()->with('error', "Hanya pesanan 'masuk' yang bisa dibatalkan");
        }

        $pesanan->update(['status' => 'dibatalkan']);
        return redirect()->route('admin.pesanan.dibatalkan')
            ->with('success', "Pesanan {$pesanan->code} berhasil dibatalkan");
    }
}