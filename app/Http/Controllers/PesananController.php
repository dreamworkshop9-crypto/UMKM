<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function masuk()
    {
        return view('pesanan.masuk');
    }

    public function konfirmasi($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.konfirmasi', compact('pesanan'));
    }

    public function doKonfirmasi(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'dikonfirmasi']);
        return response()->json(['message' => "Pesanan {$pesanan->code} dikonfirmasi"]);
    }

    public function dalamPerjalanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.dalam_perjalanan', compact('pesanan'));
    }

    public function doDalamPerjalanan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'dalam_perjalanan']);
        return response()->json(['message' => "Pesanan {$pesanan->code} dalam perjalanan"]);
    }

    public function dikemas($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanans.dikemas', compact('pesanan'));
    }

    public function doDikemas(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'dikemas']);
        return response()->json(['message' => "Pesanan {$pesanan->code} dikemas"]);
    }

    public function dikirim($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.dikirim', compact('pesanan'));
    }

    public function doDikirim(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'dikirim']);
        return response()->json(['message' => "Pesanan {$pesanan->code} dikirim"]);
    }

    public function selesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.selesai', compact('pesanan'));
    }

    public function doSelesai(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'selesai']);
        return response()->json(['message' => "Pesanan {$pesanan->code} selesai"]);
    }

    public function dibatalkan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.dibatalkan', compact('pesanan'));
    }

    public function doDibatalkan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'dibatalkan']);
        return response()->json(['message' => "Pesanan {$pesanan->code} dibatalkan"]);
    }

    public function list()
    {
        return response()->json(Pesanan::orderByDesc('id')->get());
    }

    public function show($id)
    {
        return response()->json(Pesanan::findOrFail($id));
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $code = $pesanan->code;
        $pesanan->delete();
        return response()->json(['message' => "Pesanan \"{$code}\" dihapus"]);
    }
}
