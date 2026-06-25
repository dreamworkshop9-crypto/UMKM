<?php
namespace App\Http\Controllers;
use App\Models\{Order,OrderItem,Cart,Pesanan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB};
use Illuminate\Support\Str;
 
class OrderController extends Controller {
    public function index() {
        return redirect()->route('shop', ['open_account' => 'pesanan']);
    }
    public function checkout(Request $req) {
        $req->validate(['name'=>'required','phone'=>'required','address'=>'required','city'=>'required','postal_code'=>'required','payment_method'=>'required|in:cod,transfer']);
        $items = Cart::with('product')->where('user_id',Auth::id())->get();
        if ($items->isEmpty()) return back()->with('error','Keranjang kosong.');
        $order = null;
        DB::transaction(function() use($req,$items, &$order) {
            $order = Order::create([
            'customer_name' => Auth::user()->name ?? 'Tamu','user_id'=>Auth::id(),'invoice'=>'INV-'.strtoupper(Str::random(10)),'name'=>$req->name,'phone'=>$req->phone,'address'=>$req->address,'city'=>$req->city,'postal_code'=>$req->postal_code,'payment_method'=>$req->payment_method,'total'=>$items->sum(fn($i)=>$i->product->price*$i->quantity),'status'=>'pending']);
            foreach($items as $i) OrderItem::create(['order_id'=>$order->id,'product_id'=>$i->product_id,'quantity'=>$i->quantity,'price'=>$i->product->price,'size'=>$i->size,'color'=>$i->color]);
            Cart::where('user_id',Auth::id())->delete();
        });
        return redirect()->route('order.index')->with('success','Pesanan berhasil dibuat!');
    }
    public function show($invoice) {
        Order::where('invoice',$invoice)->where('user_id',Auth::id())->firstOrFail();
        return redirect()->route('shop', ['open_account' => 'pesanan', 'open_order' => $invoice]);
    }
    public function track(Request $req) {
        $req->validate(['invoice'=>'required|string']);
        $order = Order::where('invoice',$req->invoice)->first();
        if (!$order) return response()->json(['found'=>false,'message'=>'Pesanan tidak ditemukan.']);
        return response()->json(['found'=>true,'invoice'=>$order->invoice,'status'=>$order->status_label,'date'=>$order->created_at->format('d M Y'),'total'=>$order->total_formatted]);
    }
}
