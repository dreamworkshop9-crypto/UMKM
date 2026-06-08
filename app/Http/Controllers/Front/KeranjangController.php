<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk')->where('user_id', Auth::id())->latest()->get()
            ->map(fn ($item) => [
                'id'        => $item->id,
                'produk_id' => $item->product_id,
                'nama'      => $item->produk->name ?? '',
                'foto'      => $item->produk->image_url ?? '',
                // ✅ Ambil harga langsung dari relasi produk, bukan dari tabel carts
                'harga'     => $item->produk->price ?? 0, 
                'ukuran'    => $item->size,
                'qty'       => $item->quantity,
            ]);

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'ukuran'    => 'nullable|string',
            'qty'       => 'required|integer|min:1',
        ]);

        $produk = Product::findOrFail($request->produk_id);

        $existing = Keranjang::where('user_id', Auth::id())
            ->where('product_id', $request->produk_id)
            ->where('size', $request->ukuran)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $request->qty;
            if ($newQty > $produk->stock) {
                return response()->json(['message' => 'Stok maksimal ' . $produk->stock], 422);
            }
            $existing->update(['quantity' => $newQty]);
        } else {
            if ($request->qty > $produk->stock) {
                return response()->json(['message' => 'Stok tidak mencukupi'], 422);
            }
            // ✅ Tidak menyimpan 'price' karena kolomnya tidak ada di tabel carts
            Keranjang::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->produk_id,
                'size'       => $request->ukuran,
                'quantity'   => $request->qty,
            ]);
        }

        return $this->index()->setStatusCode(201);
    }

    public function updateQty(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        $item = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->qty > $item->produk->stock) {
            return response()->json(['message' => 'Stok maksimal ' . $item->produk->stock], 422);
        }

        $item->update(['quantity' => $request->qty]);

        return $this->index();
    }

    public function hapus($id)
    {
        Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();

        return $this->index();
    }
}