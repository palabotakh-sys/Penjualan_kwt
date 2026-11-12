@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->order_code)
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('orders.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">← Kembali ke Daftar Pesanan</a>
        <div class="font-mono text-xs font-bold text-gray-400">Nota: {{ $order->order_code }}</div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-semibold">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-sm font-semibold">
        ❌ {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm space-y-8">
        <!-- HEADER STATUS -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-gray-100 gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900">Pesanan Sayur #{{ $order->order_code }}</h1>
                <p class="text-xs text-gray-400 mt-1">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="flex flex-col gap-2 items-end">
                @php
                    $pbadges = [
                        'unpaid'   => ['bg' => 'bg-amber-100 text-amber-800',   'label' => '⏳ Menunggu Pembayaran'],
                        'pending'  => ['bg' => 'bg-blue-100 text-blue-800',     'label' => '🔄 Sedang Diverifikasi'],
                        'paid'     => ['bg' => 'bg-emerald-100 text-emerald-800','label' => '✅ Pembayaran Lunas'],
                        'rejected' => ['bg' => 'bg-rose-100 text-rose-800',     'label' => '❌ Pembayaran Ditolak'],
                    ];
                    $obadges = [
                        'pending'   => 'bg-amber-100 text-amber-700',
                        'processed' => 'bg-blue-100 text-blue-700',
                        'shipped'   => 'bg-purple-100 text-purple-700',
                        'delivered' => 'bg-emerald-100 text-emerald-700',
                        'cancelled' => 'bg-rose-100 text-rose-700',
                    ];
                @endphp
                <span class="px-4 py-2 rounded-2xl text-xs font-black {{ $pbadges[$order->payment_status]['bg'] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $pbadges[$order->payment_status]['label'] ?? $order->payment_status }}
                </span>
                <span class="px-4 py-1.5 rounded-2xl text-xs font-bold {{ $obadges[$order->order_status] ?? 'bg-gray-100 text-gray-700' }}">
                    Status: {{ ucfirst($order->order_status) }}
                </span>
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <div>
            <h3 class="font-bold text-xs uppercase tracking-wider text-gray-400 mb-4">Rincian Sayuran Dipesan</h3>
            <div class="divide-y divide-gray-100 text-sm">
                @foreach($order->orderItems as $item)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <div class="font-extrabold text-gray-900">{{ $item->product->name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->quantity }} {{ $item->product->unit }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                    </div>
                    <div class="font-black text-emerald-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
            <div class="pt-4 border-t border-gray-100 flex justify-between font-black text-base text-gray-900">
                <span>Total Pembayaran:</span>
                <span class="text-emerald-700 text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- ALAMAT & CATATAN -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="text-xs font-bold text-gray-400 uppercase mb-1">📍 Alamat Pengiriman</div>
                <div class="text-gray-800 font-semibold">{{ $order->shipping_address }}</div>
                <div class="text-xs text-gray-400 mt-1">📞 {{ $order->customer_phone }}</div>
            </div>
            @if($order->customer_notes)
            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <div class="text-xs font-bold text-gray-400 uppercase mb-1">📝 Catatan</div>
                <div class="text-gray-700">{{ $order->customer_notes }}</div>
            </div>
            @endif
        </div>

        <!-- PAYMENT SECTION (UNPAID) -->
        @if($order->payment_status === 'unpaid')
        <div class="space-y-5">
            <h3 class="font-black text-gray-900 text-base border-b border-gray-100 pb-3">💳 Pilih Metode Pembayaran</h3>

            {{-- QRIS PAYMENT --}}
            @if(isset($qrisData) && $qrisData['is_active'] && $qrisData['is_configured'])
            <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-50 to-green-50 border-2 border-emerald-300 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 rounded-2xl flex items-center justify-center text-white text-xl">⚡</div>
                    <div>
                        <div class="font-black text-emerald-900 text-base">Bayar via QRIS</div>
                        <div class="text-xs text-emerald-700">Scan QR → Nominal otomatis terisi → Bayar</div>
                    </div>
                    <span class="ml-auto text-xs font-black bg-emerald-600 text-white px-3 py-1 rounded-full">RECOMMENDED</span>
                </div>

                <div class="flex flex-col items-center space-y-3">
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-emerald-100 inline-block">
                        <img src="{{ $qrisData['qr_url'] }}"
                             alt="QRIS {{ $qrisData['merchant_name'] }}"
                             class="w-56 h-56 object-contain"
                             loading="lazy">
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-400">Merchant</div>
                        <div class="font-black text-emerald-900 text-sm">{{ $qrisData['merchant_name'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">Nominal</div>
                        <div class="font-black text-emerald-700 text-lg">{{ $qrisData['formatted_amount'] }}</div>
                    </div>
                </div>

                <div class="bg-emerald-900/5 rounded-2xl p-3 text-xs text-emerald-900 space-y-1">
                    <div class="font-bold">📱 Cara Bayar QRIS:</div>
                    <ol class="list-decimal list-inside space-y-0.5 text-emerald-800">
                        <li>Buka aplikasi DANA / GoPay / OVO / LinkAja / Mobile Banking / dll</li>
                        <li>Pilih menu <strong>Scan QR / QRIS</strong></li>
                        <li>Scan QR di atas — nominal <strong>{{ $qrisData['formatted_amount'] }}</strong> akan otomatis terisi</li>
                        <li>Konfirmasi & bayar</li>
                        <li>Screenshot bukti pembayaran lalu upload di bawah</li>
                    </ol>
                </div>

                <!-- Upload bukti QRIS -->
                <form action="{{ route('orders.upload-payment', $order->order_code) }}" method="POST" enctype="multipart/form-data" class="space-y-3 pt-2 border-t border-emerald-200">
                    @csrf
                    <label class="block text-xs font-bold text-emerald-900 uppercase">📤 Upload Screenshot Bukti Pembayaran QRIS</label>
                    <input type="file" name="payment_proof" required accept="image/*"
                        class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3 rounded-xl transition text-sm shadow-md shadow-emerald-200">
                        ✅ Konfirmasi Pembayaran QRIS
                    </button>
                </form>
            </div>
            @endif

            {{-- TRANSFER BANK --}}
            @if($order->paymentMethod)
            <div class="p-6 rounded-3xl bg-blue-50/60 border border-blue-200/80 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-xl">🏦</div>
                    <div>
                        <div class="font-black text-blue-900 text-base">Transfer Bank</div>
                        <div class="text-xs text-blue-700">Transfer manual ke rekening resmi KWT</div>
                    </div>
                </div>
                <p class="text-xs text-blue-900/80">Lakukan transfer tepat sejumlah <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> ke:</p>
                <div class="bg-white p-4 rounded-2xl border border-blue-100 font-mono">
                    <div class="text-xs text-gray-400 uppercase font-sans">Bank Tujuan:</div>
                    <div class="text-lg font-black text-blue-800">{{ $order->paymentMethod->bank_name }}</div>
                    <div class="text-xl font-bold text-gray-900 tracking-wider my-1">{{ $order->paymentMethod->account_number }}</div>
                    <div class="text-xs text-gray-600 font-sans">Atas Nama: <strong>{{ $order->paymentMethod->account_holder }}</strong></div>
                </div>

                <form action="{{ route('orders.upload-payment', $order->order_code) }}" method="POST" enctype="multipart/form-data" class="space-y-3 pt-2 border-t border-blue-200">
                    @csrf
                    <label class="block text-xs font-bold text-blue-900 uppercase">📤 Upload Bukti Transfer</label>
                    <input type="file" name="payment_proof" required accept="image/*"
                        class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 rounded-xl transition text-sm">
                        📤 Kirim Bukti Transfer
                    </button>
                </form>
            </div>
            @endif

            {{-- Fallback: tidak ada metode --}}
            @if(!isset($qrisData['is_configured']) && !$order->paymentMethod)
            <div class="p-5 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-sm">
                ⚠️ Belum ada metode pembayaran yang tersedia. Hubungi admin KWT Ariyad Jaya.
            </div>
            @endif
        </div>

        @elseif($order->payment_proof)
        <div class="p-6 rounded-3xl bg-gray-50 border border-gray-100 space-y-3">
            <h3 class="font-black text-gray-800 text-xs uppercase tracking-wider">Bukti Pembayaran Terkirim</h3>
            <div class="w-48 h-48 rounded-2xl overflow-hidden border border-gray-200">
                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover" alt="Bukti Pembayaran">
            </div>
            <p class="text-xs text-gray-500">Bukti pembayaran telah kami terima dan dalam pengecekan oleh Bendahara KWT Ariyad Jaya.</p>
        </div>

        @elseif($order->payment_status === 'paid')
        <div class="p-5 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-semibold">
            ✅ Pembayaran telah diverifikasi. Terima kasih telah berbelanja di KWT Ariyad Jaya!
        </div>
        @endif
    </div>
</div>
@endsection
