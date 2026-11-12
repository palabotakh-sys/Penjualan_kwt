<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function index() {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product.category')->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        return view('frontend.cart.index', compact('cartItems', 'total'));
    }
    public function add(Request $request) {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:1']);
        $product = Product::findOrFail($request->product_id);
        if (!$product->isAvailable()) {
            return back()->with('error', 'Produk tidak tersedia.');
        }
        $cartItem = CartItem::firstOrNew(['user_id' => auth()->id(), 'product_id' => $request->product_id]);
        $newQty = ($cartItem->exists ? $cartItem->quantity : 0) + $request->quantity;
        if ($newQty > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock . ' ' . $product->unit);
        }
        $cartItem->quantity = $newQty;
        $cartItem->save();
        return back()->with('success', $product->name . ' berhasil ditambahkan ke keranjang!');
    }
    public function update(Request $request, int $id) {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem = CartItem::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        if ($request->quantity > $cartItem->product->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }
        $cartItem->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui.');
    }
    public function remove(int $id) {
        CartItem::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
