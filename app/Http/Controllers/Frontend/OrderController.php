<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Services\QrisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    public function checkout() {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        $total = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('frontend.orders.checkout', compact('cartItems', 'total', 'paymentMethods'));
    }
    public function store(Request $request) {
        $request->validate([
            'shipping_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'customer_notes' => 'nullable|string',
        ]);
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        DB::transaction(function () use ($request, $cartItems) {
            $total = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
            $order = Order::create([
                'order_code' => Order::generateCode(),
                'user_id' => auth()->id(),
                'payment_method_id' => $request->payment_method_id,
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'customer_phone' => $request->customer_phone,
                'customer_notes' => $request->customer_notes,
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'unit_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }
            CartItem::where('user_id', auth()->id())->delete();
        });
        $order = Order::where('user_id', auth()->id())->latest()->first();
        return redirect()->route('orders.show', $order->order_code)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
    public function index() {
        $orders = Order::where('user_id', auth()->id())->with('orderItems.product')->latest()->paginate(10);
        return view('frontend.orders.index', compact('orders'));
    }
    public function show(string $orderCode) {
        $order = Order::where('order_code', $orderCode)->where('user_id', auth()->id())->with(['orderItems.product', 'paymentMethod'])->firstOrFail();
        $qrisData = QrisService::getDynamicQrisData($order->total_amount);
        return view('frontend.orders.show', compact('order', 'qrisData'));
    }
    public function uploadPayment(Request $request, string $orderCode) {
        $request->validate(['payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        $order = Order::where('order_code', $orderCode)->where('user_id', auth()->id())->where('payment_status', 'unpaid')->firstOrFail();
        $path = $request->file('payment_proof')->store('payment-proofs', 'public');
        $order->update(['payment_proof' => $path, 'payment_status' => 'pending']);
        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
