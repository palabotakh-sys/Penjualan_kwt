<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CashMutation;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $query = Order::with(['user', 'orderItems'])->latest();
        if ($request->filled('status')) $query->where('payment_status', $request->status);
        if ($request->filled('search')) $query->whereHas('user', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))->orWhere('order_code', 'like', '%'.$request->search.'%');
        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }
    public function show(Order $order) {
        $order->load(['user', 'orderItems.product', 'paymentMethod', 'confirmedBy']);
        return view('admin.orders.show', compact('order'));
    }
    public function confirm(Order $order) {
        if ($order->payment_status !== 'pending') return back()->with('error', 'Status pembayaran tidak valid untuk dikonfirmasi.');
        $order->update(['payment_status' => 'paid', 'order_status' => 'processed', 'confirmed_by' => auth()->id(), 'confirmed_at' => now()]);
        CashMutation::create([
            'order_id' => $order->id,
            'transaction_type' => 'in',
            'amount' => $order->total_amount,
            'category' => 'penjualan_produk',
            'description' => 'Pemasukan dari pesanan ' . $order->order_code,
            'recorded_by' => auth()->id(),
            'transaction_date' => now()->toDateString(),
        ]);
        return back()->with('success', 'Pembayaran dikonfirmasi dan kas penjualan dicatat!');
    }
    public function reject(Order $order) {
        if ($order->payment_status !== 'pending') return back()->with('error', 'Status tidak valid.');
        $order->update(['payment_status' => 'rejected', 'order_status' => 'cancelled']);
        foreach ($order->orderItems as $item) {
            $item->product->increment('stock', $item->quantity);
        }
        return back()->with('success', 'Pembayaran ditolak. Stok produk dikembalikan.');
    }
    public function updateStatus(Request $request, Order $order) {
        $request->validate(['order_status' => 'required|in:pending,processed,shipped,completed,cancelled']);
        $order->update(['order_status' => $request->order_status]);
        return back()->with('success', 'Status pesanan diperbarui!');
    }
}
