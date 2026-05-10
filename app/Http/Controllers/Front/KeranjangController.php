<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class KeranjangController extends Controller
{
    private function getCart(): array
    {
        return Session::get('keranjang_landing', []);
    }

    private function saveCart(array $cart): void
    {
        Session::put('keranjang_landing', $cart);
    }

    private function enrichCart(array $cart): array
    {
        return collect($cart)->map(function ($item) {
            $produk = Produk::find($item['produk_id']);
            $gambar = null;
            if ($produk) {
                $gambar = $produk->gambar;
            }
            return [
                'id'        => $item['id'],
                'produk_id' => $item['produk_id'],
                'nama'      => $produk->name ?? 'Produk tidak ditemukan',
                'harga'     => $produk->price ?? 0,
                'foto'      => $gambar,
                'ukuran'    => $item['ukuran'] ?? null,
                'qty'       => $item['qty'],
                'stok'      => $produk->stock ?? 0,
            ];
        })->values()->all();
    }

    public function index()
    {
        return response()->json(['data' => $this->enrichCart($this->getCart())]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'ukuran'    => 'nullable|string',
            'qty'       => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stock < $request->qty) {
            return response()->json([
                'message' => "Stok {$produk->name} tidak mencukupi (sisa: {$produk->stock})"
            ], 422);
        }

        $cart = $this->getCart();

        $idx = collect($cart)->search(function ($item) use ($request) {
            return $item['produk_id'] == $request->produk_id
                && ($item['ukuran'] ?? null) == ($request->ukuran ?? null);
        });

        if ($idx !== false) {
            $newQty = $cart[$idx]['qty'] + $request->qty;
            if ($newQty > $produk->stock) {
                return response()->json(['message' => "Stok tidak mencukupi (sisa: {$produk->stock})"], 422);
            }
            $cart[$idx]['qty'] = $newQty;
        } else {
            $cart[] = [
                'id'        => uniqid('c_'),
                'produk_id' => $request->produk_id,
                'ukuran'    => $request->ukuran,
                'qty'       => $request->qty,
            ];
        }

        $this->saveCart($cart);

        return response()->json([
            'message' => "{$produk->name} ditambahkan ke keranjang",
            'data'    => $this->enrichCart($cart),
        ]);
    }

    public function hapus($id)
    {
        $cart = collect($this->getCart())->filter(fn ($i) => $i['id'] !== $id)->values()->all();
        $this->saveCart($cart);
        return response()->json(['data' => $this->enrichCart($cart)]);
    }

    public function updateQty(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        $cart = $this->getCart();
        $idx = collect($cart)->search(fn ($i) => $i['id'] === $id);

        if ($idx === false) {
            return response()->json(['message' => 'Item tidak ditemukan'], 404);
        }

        $produk = Produk::find($cart[$idx]['produk_id']);

        if ($request->qty > $produk->stock) {
            return response()->json(['message' => "Stok tidak mencukupi (sisa: {$produk->stock})"], 422);
        }

        $cart[$idx]['qty'] = $request->qty;
        $this->saveCart($cart);

        return response()->json(['data' => $this->enrichCart($cart)]);
    }
}