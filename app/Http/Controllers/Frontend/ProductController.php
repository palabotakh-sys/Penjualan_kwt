<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::where('is_active', true)->with('category');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('sort')) {
            match($request->sort) {
                'price_asc' => $query->orderBy('price'),
                'price_desc' => $query->orderByDesc('price'),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        return view('frontend.products.index', compact('products', 'categories'));
    }
    public function show(string $slug) {
        $product = Product::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $related = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('is_active', true)->take(4)->get();
        return view('frontend.products.show', compact('product', 'related'));
    }
}
