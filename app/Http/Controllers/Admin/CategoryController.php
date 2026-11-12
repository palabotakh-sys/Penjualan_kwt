<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index() { return view('admin.categories.index', ['categories' => Category::withCount('products')->get()]); }
    public function create() { return view('admin.categories.create'); }
    public function store(Request $request) {
        $data = $request->validate(['name' => 'required|string|max:100|unique:categories']);
        Category::create(['name' => $data['name'], 'slug' => Str::slug($data['name'])]);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }
    public function edit(Category $kategori) { return view('admin.categories.edit', ['category' => $kategori]); }
    public function update(Request $request, Category $kategori) {
        $data = $request->validate(['name' => 'required|string|max:100|unique:categories,name,'.$kategori->id]);
        $kategori->update(['name' => $data['name'], 'slug' => Str::slug($data['name'])]);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }
    public function destroy(Category $kategori) {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
    public function show(Category $kategori) { return redirect()->route('admin.kategori.edit', $kategori->id); }
}
