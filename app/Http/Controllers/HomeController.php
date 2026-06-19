<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
 
class HomeController extends Controller {
    public function index() {
        $featuredProducts = Product::with(['category','brand'])->where('is_active',true)->latest()->take(9)->get();
        $newProducts      = Product::with(['category','brand'])->where('is_active',true)->where('is_new',true)->latest()->take(2)->get();
        $bestSellers      = Product::with(['category','brand'])->where('is_active',true)->where('is_best_seller',true)->latest()->take(2)->get();
        $newCollection    = Product::with(['category','brand'])->where('is_active',true)->where('is_new',true)->latest()->take(4)->get();
        $promoProducts    = Product::with(['category','brand'])->where('is_active',true)->whereNotNull('old_price')->latest()->take(3)->get();
        $categories       = Category::whereNull('parent_id')->with(['children.children'])->get();
        $brands           = Brand::where('is_active',true)->get();
        return view('pages.home', compact('featuredProducts','newProducts','bestSellers','newCollection','promoProducts','categories','brands'));
    }
}
