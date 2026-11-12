@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->order_code)
@section('page-title', 'Detail Pesanan & Verifikasi Bayar')
@section('page-subtitle', 'Periksa bukti struk transfer dan lakukan approval pembayaran')
@section('content')
<div class="max-w-4xl space-y-6">
    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <span class="text-xs font-mono font-bold text-gray-400">#{{ $order->order_code }}</span>
                <h2 class="text-xl font-black text-gray-900 mt-0.5">Pemesan: {{ $order->user->name }}</h2>
                <div class="text-xs text-gray-500 mt-1">Kontak: {{ $order->customer_phone }} | Alamat: {{ $order->shipping_address }}</div>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-400">Total Transaksi</div>
                <div class="text-2xl font-black text-emerald-700">{{ $order->formatted_total }}</div>
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <div>
            <h4 class="text-xs font-bold uppercase text-gray-400 mb-3">Item Sayuran Dipesan</h4>
            <div class="divide-y divide-gray-100 text-xs">
                @foreach($order->orderItems as $item)
                <div class="py-2.5 flex justify-between">
                    <div>
                        <span class="font-bold text-gray-800">{{ $item->product->name }}</span>
                        <span class="text-gray-400">({{ $item->quantity }} {{ $item->product->unit }})</span>
                    </div>
                    <div class="font-bold text-gray-800">{{ $item->formatted_subtotal }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- VERIFIKASI PEMBAYARAN -->
        <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 space-y-4">
            <h4 class="text-xs font-black uppercase text-gray-700">Verifikasi Bukti Transfer</h4>
            @if($order->payment_proof)
                <div class="w-64 h-64 rounded-2xl overflow-hidden border border-gray-200">
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover" title="Klik untuk perbesar">
                    </a>
                </div>
            @else
                <p class="text-xs text-amber-700">Pembeli belum mengunggah bukti pembayaran.</p>
            @endif

            @if($order->payment_status === 'pending')
                <div class="pt-3 flex gap-3">
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition">
                            ✅ Konfirmasi Bayar (Lunas & Catat ke Kas)
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition" onclick="return confirm('Tolak pembayaran pesanan ini?')">
                            ❌ Tolak Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- STATUS ORDER DROPDOWN -->
        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-3 pt-2">
            @csrf @method('PATCH')
            <span class="text-xs font-bold text-gray-700">Status Proses:</span>
            <select name="order_status" class="px-4 py-2 rounded-xl border border-gray-200 text-xs font-bold">
                @foreach(['pending' => 'Pending', 'processed' => 'Diproses / Dikemas', 'shipped' => 'Sedang Dikirim', 'completed' => 'Selesai Diterima', 'cancelled' => 'Dibatalkan'] as $val => $lbl)
                    <option value="{{ $val }}" {{ $order->order_status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-4 py-2 rounded-xl text-xs">
                Perbarui Status
            </button>
        </form>
    </div>
</div>
@endsection
