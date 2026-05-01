<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
 
class ProductController extends Controller {
    public function index(Request $req) {
        $q = Product::with(['category','brand'])->where('is_active',true);
        if ($req->filled('category')) $q->whereHas('category', fn($x)=>$x->where('slug',$req->category));
        if ($req->filled('brand'))    $q->whereHas('brand', fn($x)=>$x->where('slug',$req->brand));
        if ($req->filled('min_price')) $q->where('price','>=',$req->min_price);
        if ($req->filled('max_price')) $q->where('price','<=',$req->max_price);
        if ($req->filled('q'))         $q->where('name','like','%'.$req->q.'%');
        match($req->sort) { 'price_asc'=>$q->orderBy('price'), 'price_desc'=>$q->orderByDesc('price'), default=>$q->latest() };
        $products   = $q->paginate(12)->withQueryString();
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $brands     = Brand::where('is_active',true)->get();
        return view('pages.shop', compact('products','categories','brands'));
    }
    public function show($id, $slug) {
        $product = Product::with(['category','brand','images','variants'])->where('is_active',true)->findOrFail($id);
        $related = Product::with(['category','brand'])->where('is_active',true)->where('category_id',$product->category_id)->where('id','!=',$product->id)->take(4)->get();
        return view('pages.product-detail', compact('product','related'));
    }
    public function bySubcategory($id, $slug) {
        $category = \App\Models\Category::findOrFail($id);
        $products = Product::with(['category','brand'])->where('is_active',true)->where('subcategory_id',$id)->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $brands = Brand::where('is_active',true)->get();
        return view('pages.shop', compact('products','categories','brands','category'));
    }
    public function bySubSubcategory($id, $slug) {
        $category = \App\Models\Category::findOrFail($id);
        $products = Product::with(['category','brand'])->where('is_active',true)->where('subsubcategory_id',$id)->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $brands = Brand::where('is_active',true)->get();
        return view('pages.shop', compact('products','categories','brands','category'));
    }
}
