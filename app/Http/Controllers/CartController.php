<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(fn ($item) => ($item->product->price ?? 0) * ($item->quantity ?? 0));

        return view('pages.cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity'   => 'integer|min:1',
            'size'       => 'nullable|string',
            'color'      => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = (int) ($request->quantity ?? 1);

        $existing = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('size', $request->size ?? null)
            ->where('color', $request->color ?? null)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $qty;
            if ($newQty > $product->stock) {
                return response()->json(['success' => false, 'message' => 'Stok maksimal ' . $product->stock], 422);
            }

            $existing->increment('quantity', $qty);
        } else {
            if ($qty > $product->stock) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi'], 422);
            }

            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => $qty,
                'size'       => $request->size ?? null,
                'color'      => $request->color ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'count'   => Cart::where('user_id', Auth::id())->sum('quantity'),
        ]);
    }

    public function update(Request $request)
    {
        $cartId = $request->input('cart_id') ?? $request->input('id');
        $qty = (int) ($request->input('quantity') ?? $request->input('qty') ?? 1);

        $item = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($qty < 1) {
            return $this->remove($request);
        }

        if ($qty > ($item->product->stock ?? 0)) {
            return response()->json(['success' => false, 'message' => 'Stok maksimal ' . ($item->product->stock ?? 0)], 422);
        }

        $item->update(['quantity' => $qty]);

        return response()->json(['success' => true, 'message' => 'Kuantitas diperbarui.']);
    }

    public function remove(Request $request)
    {
        $cartId = $request->input('cart_id') ?? $request->input('id');

        Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json(['success' => true, 'message' => 'Produk dihapus dari keranjang.']);
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return response()->json(['success' => true, 'message' => 'Keranjang berhasil dibersihkan.']);
    }
}
