@extends('layouts.app')
@section('title', 'Form Pemesanan & Checkout')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-black text-gray-900 mb-8">📦 Form Pemesanan Sayur</h1>

    <form method="POST" action="{{ route('orders.store') }}" class="grid lg:grid-cols-12 gap-8 items-start">
        @csrf
        <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm space-y-6">
            <h3 class="font-black text-base text-gray-900 pb-3 border-b border-gray-100">1. Alamat & Kontak Pengiriman</h3>
            
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pemesan</label>
                <input type="text" value="{{ auth()->user()->name }}" disabled
                    class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm font-semibold text-gray-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone_number) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Contoh: 08123456789">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Lengkap Pengiriman <span class="text-rose-500">*</span></label>
                <textarea name="shipping_address" rows="3" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Nama jalan, nomor rumah, RT/RW, patokan...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Catatan Tambahan (Opsional)</label>
                <input type="text" name="customer_notes" value="{{ old('customer_notes') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Contoh: Tolong pilihkan tomat yang masih agak hijau...">
            </div>

            <h3 class="font-black text-base text-gray-900 pt-4 pb-3 border-b border-gray-100">2. Rekening Pembayaran KWT</h3>
            <div class="space-y-3">
                @foreach($paymentMethods as $pm)
                <label class="flex items-start p-4 rounded-2xl border border-emerald-100 bg-emerald-50/40 hover:bg-emerald-50 cursor-pointer transition">
                    <input type="radio" name="payment_method_id" value="{{ $pm->id }}" {{ $loop->first ? 'checked' : '' }} class="mt-1 text-emerald-600 focus:ring-emerald-500">
                    <div class="ml-3">
                        <div class="font-extrabold text-sm text-emerald-950">{{ $pm->bank_name }}</div>
                        <div class="font-mono text-sm font-bold text-emerald-700">{{ $pm->account_number }}</div>
                        <div class="text-xs text-gray-500">a.n. {{ $pm->account_holder }}</div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
            <h3 class="font-black text-base text-gray-900 pb-3 border-b border-gray-100">Rincian Pembelian</h3>
            <div class="space-y-3 max-h-60 overflow-y-auto divide-y divide-gray-50 text-xs">
                @foreach($cartItems as $item)
                <div class="pt-2 first:pt-0 flex justify-between">
                    <div>
                        <div class="font-bold text-gray-800">{{ $item->product->name }}</div>
                        <div class="text-gray-400">{{ $item->quantity }} {{ $item->product->unit }} x {{ $item->product->formatted_price }}</div>
                    </div>
                    <div class="font-black text-emerald-700">{{ $item->formatted_subtotal }}</div>
                </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-between font-black text-lg text-gray-900">
                <span>Total Bayar:</span>
                <span class="text-emerald-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-amber-50 text-amber-900 text-xs leading-relaxed border border-amber-200/60">
                💡 <strong>Catatan:</strong> Setelah menekan tombol konfirmasi, Anda akan diarahkan ke halaman transfer untuk mengunggah bukti bayar struk/transfer.
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-emerald-200 transition text-sm">
                Konfirmasi & Buat Pesanan ✓
            </button>
        </div>
    </form>
</div>
@endsection
