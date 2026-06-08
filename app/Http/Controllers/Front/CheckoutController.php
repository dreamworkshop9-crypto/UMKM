<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah'    => 'required|integer|min:1',
            'alamat'    => 'nullable|string|min:10',
        ]);

        $produk = Product::findOrFail($request->produk_id);

        if ($produk->stock < $request->jumlah) {
            return back()->withErrors(['stok' => 'Stok produk tidak mencukupi.'])->withInput();
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'invoice' => Order::generateCode(),
            'customer_name' => Auth::user()->name,
            'customer_phone' => Auth::user()->phone ?? '-',
            'shipping_address' => $request->alamat ?? '-',
            'total' => $produk->price * $request->jumlah,
            'payment_method' => 'cod',
            'status' => 'menunggu_konfirmasi',
            'notes' => null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $produk->id,
            'quantity' => $request->jumlah,
            'price' => $produk->price,
            'size' => null,
            'color' => null,
        ]);

        $produk->decrement('stock', $request->jumlah);

        return redirect()->route('pesanan.sukses');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat'     => 'required|string|min:10',
            'provinsi'   => 'required|string',
            'kurir'      => 'required|string',
            'ongkir'     => 'required|integer|min:0',
            'pembayaran' => 'required|string',
            'catatan'    => 'nullable|string',
            'coupon'     => 'nullable|string',
            'total'      => 'required|integer|min:1',
        ]);

        $items = Keranjang::with('produk')->where('user_id', Auth::id())->get();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong'], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Sesi habis, silakan login ulang.'], 401);
        }

        return DB::transaction(function () use ($request, $items, $user) {
            
            foreach ($items as $item) {
                if (!$item->produk) {
                    return response()->json([
                        'message' => 'Produk tidak ditemukan atau sudah dihapus. Silakan hapus dari keranjang.'
                    ], 422);
                }
            }

            $order = Order::create([
                'user_id'          => $user->id,
                'invoice'          => Order::generateCode(),
                'customer_name'    => $user->name,
                'customer_phone'   => $user->phone ?? '-',
                'name'             => $user->name,
                'phone'            => $user->phone ?? '-',
                'address'          => $request->alamat,
                'city'             => $request->provinsi ?? null,
                'postal_code'      => null,
                'shipping_address' => $request->alamat,
                'total'            => (int) $request->total,
                'payment_method'   => $request->pembayaran ?? 'cod',
                'status'           => $request->pembayaran === 'cod'
                    ? 'menunggu_konfirmasi'
                    : 'menunggu_pembayaran',
                'notes'            => $request->catatan ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->produk->price, 
                    'size'       => $item->size,
                    'color'      => $item->color ?? '-',
                ]);

                $item->produk->decrement('stock', $item->quantity); 
            }

            Keranjang::where('user_id', $user->id)->delete();

            if ($request->pembayaran !== 'cod') {
                $simulatedVa = null;
                if (strpos($request->pembayaran, 'va_') === 0) {
                    $simulatedVa = '8' . implode('', array_map(function() { return rand(0, 9); }, range(1, 15)));
                }

                return response()->json([
                    'success' => true,
                    'data'    => [
                        'code'         => $order->invoice,
                        'redirect_url' => null,
                        'va_number'    => $simulatedVa,
                        'qr_url'       => null,
                        'total'        => $order->total,
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'data'    => ['code' => $order->invoice],
            ]);
        });
    }
}