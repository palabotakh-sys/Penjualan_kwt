<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CashMutation;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index(Request $request) {
        $start = $request->get('start_date', now()->startOfMonth()->toDateString());
        $end = $request->get('end_date', now()->toDateString());
        $orders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->with(['user', 'orderItems.product'])->latest()->get();
        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $cashMutations = CashMutation::whereBetween('transaction_date', [$start, $end])->with('recorder')->get();
        $kasIn = $cashMutations->where('transaction_type', 'in')->sum('amount');
        $kasOut = $cashMutations->where('transaction_type', 'out')->sum('amount');
        return view('admin.reports.index', compact('orders', 'totalRevenue', 'totalOrders', 'start', 'end', 'cashMutations', 'kasIn', 'kasOut'));
    }
    public function export(Request $request) {
        $start = $request->get('start_date', now()->startOfMonth()->toDateString());
        $end = $request->get('end_date', now()->toDateString());
        $orders = Order::where('payment_status', 'paid')->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])->with(['user', 'orderItems.product'])->latest()->get();
        return view('admin.reports.print', compact('orders', 'start', 'end'));
    }
}
