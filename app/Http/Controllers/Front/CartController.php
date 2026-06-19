<?php

namespace App\Http\Controllers\Front; // ← Diganti ke Front

use App\Http\Controllers\Controller; // ← Ditambahkan
use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(fn ($item) => [
                'id'        => $item->id,
                'produk_id' => $item->produk_id,
                'nama'      => $item->produk->name ?? '',
                'foto'      => $item->produk->image_url ?? '',
                'harga'     => $item->harga,
                'ukuran'    => $item->ukuran,
                'qty'       => $item->qty,
            ]);

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id', // ← Diganti jadi produks (sesuai DB kamu)
            'ukuran'    => 'nullable|string',
            'qty'       => 'required|integer|min:1',
        ]);

        $produk = Product::findOrFail($request->produk_id);

        $existing = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $request->produk_id)
            ->where('ukuran', $request->ukuran)
            ->first();

        if ($existing) {
            $newQty = $existing->qty + $request->qty;
            if ($newQty > $produk->stock) {
                return response()->json(['message' => 'Stok maksimal ' . $produk->stock], 422);
            }
            $existing->update(['qty' => $newQty]);
        } else {
            if ($request->qty > $produk->stock) {
                return response()->json(['message' => 'Stok tidak mencukupi'], 422);
            }
            Keranjang::create([
                'user_id'   => Auth::id(),
                'produk_id' => $request->produk_id,
                'harga'     => $produk->price,
                'ukuran'    => $request->ukuran,
                'qty'       => $request->qty,
            ]);
        }

        return $this->index()->setStatusCode(201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        $item = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->qty > $item->produk->stock) {
            return response()->json(['message' => 'Stok maksimal ' . $item->produk->stock], 422);
        }

        $item->update(['qty' => $request->qty]);

        return $this->index();
    }

    public function destroy($id)
    {
        Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();

        return $this->index();
    }
}