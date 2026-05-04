<?php
namespace App\Http\Controllers;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class WishlistController extends Controller {
    public function index() {
        return view('pages.wishlist', ['wishlists'=>Wishlist::with('product')->where('user_id',Auth::id())->get()]);
    }
    public function toggle(Request $req) {
        $req->validate(['product_id'=>'required|exists:produks,id']);
        $w = Wishlist::where('user_id',Auth::id())->where('product_id',$req->product_id)->first();
        if ($w) { $w->delete(); return response()->json(['status'=>'removed','message'=>'Dihapus dari wishlist.']); }
        Wishlist::create(['user_id'=>Auth::id(),'product_id'=>$req->product_id]);
        return response()->json(['status'=>'added','message'=>'Ditambahkan ke wishlist!']);
    }
}
