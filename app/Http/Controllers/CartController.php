<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class CartController extends Controller {
    public function index() {
        $cartItems = Cart::with('product')->where('user_id',Auth::id())->get();
        $subtotal  = $cartItems->sum(fn($i)=>$i->product->price*$i->quantity);
        return view('pages.cart', compact('cartItems','subtotal'));
    }
    public function add(Request $req) {
        $req->validate(['product_id'=>'required|exists:produks,id','quantity'=>'required|integer|min:1']);
        $cart = Cart::where('user_id',Auth::id())->where('product_id',$req->product_id)->where('size',$req->size)->where('color',$req->color)->first();
        if ($cart) { $cart->increment('quantity',$req->quantity); }
        else { Cart::create(['user_id'=>Auth::id(),'product_id'=>$req->product_id,'quantity'=>$req->quantity,'size'=>$req->size,'color'=>$req->color]); }
        $count = Cart::where('user_id',Auth::id())->sum('quantity');
        return response()->json(['success'=>true,'message'=>'Produk ditambahkan ke keranjang!','count'=>$count]);
    }
    public function update(Request $req) {
        Cart::where('id',$req->cart_id)->where('user_id',Auth::id())->update(['quantity'=>$req->quantity]);
        return response()->json(['success'=>true]);
    }
    public function remove(Request $req) {
        Cart::where('id',$req->cart_id)->where('user_id',Auth::id())->delete();
        return response()->json(['success'=>true,'message'=>'Produk dihapus dari keranjang.']);
    }
    public function clear() {
        Cart::where('user_id',Auth::id())->delete();
        return response()->json(['success'=>true]);
    }
}
