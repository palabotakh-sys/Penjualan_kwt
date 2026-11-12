<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::with('category');
        if ($request->filled('search')) $query->where('name', 'like', '%'.$request->search.'%');
        if ($request->filled('category')) $query->where('category_id', $request->category);
        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }
    public function create() { return view('admin.products.create', ['categories' => Category::all()]); }
    public function store(Request $request) {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:products',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = auth()->id();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['is_active'] = $request->boolean('is_active', true);
        Product::create($data);
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    public function edit(Product $produk) { return view('admin.products.edit', ['product' => $produk, 'categories' => Category::all()]); }
    public function update(Request $request, Product $produk) {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:products,code,'.$produk->id,
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($produk->image) Storage::disk('public')->delete($produk->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $produk->update($data);
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }
    public function destroy(Product $produk) {
        if ($produk->image) Storage::disk('public')->delete($produk->image);
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
    public function show(Product $produk) { return view('admin.products.show', ['product' => $produk]); }
}
