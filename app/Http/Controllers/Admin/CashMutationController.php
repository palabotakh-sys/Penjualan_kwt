<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CashMutation;
use Illuminate\Http\Request;

class CashMutationController extends Controller {
    public function index(Request $request) {
        $query = CashMutation::with('recorder')->latest();
        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('type')) $query->where('transaction_type', $request->type);
        $mutations = $query->paginate(20)->withQueryString();
        $summary = [
            'penjualan' => CashMutation::where('category', 'penjualan_produk')->where('transaction_type', 'in')->sum('amount'),
            'iuran' => CashMutation::where('category', 'iuran_anggota')->where('transaction_type', 'in')->sum('amount'),
            'operasional_keluar' => CashMutation::where('category', 'operasional')->where('transaction_type', 'out')->sum('amount'),
        ];
        return view('admin.cash.index', compact('mutations', 'summary'));
    }
    public function create() { return view('admin.cash.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'transaction_type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:1',
            'category' => 'required|in:penjualan_produk,iuran_anggota,operasional',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);
        $data['recorded_by'] = auth()->id();
        CashMutation::create($data);
        return redirect()->route('admin.kas.index')->with('success', 'Mutasi kas berhasil dicatat!');
    }
    public function show(CashMutation $ka) { return redirect()->route('admin.kas.index'); }
    public function edit(CashMutation $ka) { return view('admin.cash.edit', ['mutation' => $ka]); }
    public function update(Request $request, CashMutation $ka) {
        $data = $request->validate([
            'transaction_type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:1',
            'category' => 'required|in:penjualan_produk,iuran_anggota,operasional',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);
        $ka->update($data);
        return redirect()->route('admin.kas.index')->with('success', 'Mutasi kas berhasil diperbarui!');
    }
    public function destroy(CashMutation $ka) {
        $ka->delete();
        return redirect()->route('admin.kas.index')->with('success', 'Data kas berhasil dihapus!');
    }
}
