<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller {
    public function index() { return view('admin.payment-methods.index', ['methods' => PaymentMethod::all()]); }
    public function create() { return view('admin.payment-methods.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50|unique:payment_methods',
            'account_holder' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        PaymentMethod::create($data);
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil ditambahkan!');
    }
    public function edit(PaymentMethod $rekenin) { return view('admin.payment-methods.edit', ['method' => $rekenin]); }
    public function update(Request $request, PaymentMethod $rekenin) {
        $data = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50|unique:payment_methods,account_number,'.$rekenin->id,
            'account_holder' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $rekenin->update($data);
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil diperbarui!');
    }
    public function destroy(PaymentMethod $rekenin) {
        $rekenin->delete();
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil dihapus!');
    }
    public function show(PaymentMethod $rekenin) { return redirect()->route('admin.rekening.edit', $rekenin->id); }
}
