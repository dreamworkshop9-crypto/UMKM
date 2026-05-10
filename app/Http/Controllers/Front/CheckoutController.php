<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alamat'     => 'required|min:10|max:500',
            'provinsi'   => 'required|string',
            'kurir'      => 'required|string',
            'pembayaran' => 'required|in:transfer,ewallet,cod,qris',
            'ongkir'     => 'required|integer|min:0',
            'total'      => 'required|integer|min:0',
            'catatan'    => 'nullable|string|max:255',
        ]);

        $cart = Session::get('keranjang_landing', []);

        if (empty($cart)) {
            return response()->json(['message' => 'Keranjang kosong'], 422);
        }

        $user = auth()->user();

        // Validasi stok & hitung subtotal
        $subtotal = 0;
        $items = [];
        foreach ($cart as $item) {
            $produk = Produk::find($item['produk_id']);

            if (! $produk || $produk->stock < $item['qty']) {
                return response()->json([
                    'message' => "Stok {$produk?->name ?? 'produk'} tidak mencukupi",
                ], 422);
            }

            $items[] = [
                'produk_id'  => $item['produk_id'],
                'name'       => $produk->name,
                'price'      => $produk->price,
                'ukuran'     => $item['ukuran'] ?? null,
                'qty'        => $item['qty'],
                'image'      => $produk->thumbnail ?? $produk->image ?? null,
            ];
            $subtotal += $produk->price * $item['qty'];
        }

        $grandTotal = $subtotal + $validated['ongkir'];
        if ($grandTotal !== $validated['total']) {
            return response()->json(['message' => 'Total harga tidak sesuai'], 422);
        }

        return DB::transaction(function () use ($validated, $items, $grandTotal, $subtotal, $user) {
            $code = 'ORD-' . str_pad(Pesanan::count() + 1, 5, '0', STR_PAD_LEFT);

            $pesanan = Pesanan::create([
                'code'           => $code,
                'user_id'        => $user->id,
                'customer_name'  => $user->name,
                'customer_phone' => $user->whatsapp ?? $user->phone ?? '-',
                'customer_email' => $user->email,
                'items'          => $items,
                'total_price'    => $grandTotal,
                'status'         => 'masuk',
                'notes'          => json_encode([
                    'alamat'     => $validated['alamat'],
                    'provinsi'   => $validated['provinsi'],
                    'kurir'      => $validated['kurir'],
                    'pembayaran' => $validated['pembayaran'],
                    'catatan'    => $validated['catatan'] ?? null,
                    'subtotal'   => $subtotal,
                    'ongkir'     => $validated['ongkir'],
                ]),
            ]);

            // Kurangi stok
            foreach ($items as $item) {
                $produk = Produk::find($item['produk_id']);
                if ($produk) {
                    $produk->decrement('stock', $item['qty']);
                }
            }

            Session::forget('keranjang_landing');

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'data'    => ['code' => $code],
            ]);
        });
    }
}