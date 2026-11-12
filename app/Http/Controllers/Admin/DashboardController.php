<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\CashMutation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_products' => Product::where('is_active', true)->count(),
            'low_stock' => Product::where('stock', '<', 10)->where('is_active', true)->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'kas_penjualan' => CashMutation::where('category', 'penjualan_produk')->where('transaction_type', 'in')->sum('amount'),
        ];
        $recentOrders = Order::with(['user', 'orderItems'])->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->where('is_active', true)->with('category')->get();
        $monthlySales = Order::where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(fn($order) => (int) $order->created_at->format('n'))
            ->map(fn($group, $month) => (object) [
                'month' => $month,
                'total' => $group->sum('total_amount'),
            ])
            ->values();
        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts', 'monthlySales'));
    }
}
