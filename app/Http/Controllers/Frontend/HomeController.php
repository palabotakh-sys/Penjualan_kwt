<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller {
    public function index() {
        $featuredProducts = Product::where('is_active', true)->where('stock', '>', 0)->with('category')->latest()->take(6)->get();
        $categories = Category::withCount(['products' => fn($q) => $q->where('is_active', true)])->get();
        return view('frontend.home', compact('featuredProducts', 'categories'));
    }
}
