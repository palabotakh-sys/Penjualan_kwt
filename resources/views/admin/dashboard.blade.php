@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Ringkasan Dashboard')
@section('page-subtitle', 'Monitoring Penjualan, Stok Sayur, dan Kas Kelompok Wanita Tani Ariyad Jaya')
@section('content')
<div class="space-y-8">
    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">💰</div>
            <div>
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Penjualan</div>
                <div class="text-xl font-black text-emerald-950">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold">📦</div>
            <div>
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Pesanan Pending</div>
                <div class="text-xl font-black text-amber-600">{{ $stats['pending_orders'] }} Transaksi</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">🥬</div>
            <div>
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Produk Sayuran</div>
                <div class="text-xl font-black text-blue-900">{{ $stats['total_products'] }} Jenis</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-bold">👥</div>
            <div>
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Pembeli</div>
                <div class="text-xl font-black text-purple-900">{{ $stats['total_customers'] }} Pelanggan</div>
            </div>
        </div>
    </div>

    <!-- KHUSUS PEMISAHAN KAS (BAB I SKRIPSI) -->
    <div class="bg-gradient-to-r from-emerald-900 to-green-800 text-white rounded-3xl p-6 shadow-md shadow-emerald-950/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="text-xs uppercase tracking-wider font-bold text-emerald-300">Modul Pemisahan Kas (Sesuai Bab I Skripsi)</div>
            <h2 class="text-xl font-black text-white mt-1">Saldo Arus Kas Khusus Penjualan Sayuran</h2>
            <p class="text-xs text-emerald-100/80 mt-1 max-w-xl">
                Tercatat otomatis dan dipisahkan dari kas iuran anggota untuk menjamin transparansi akuntansi kelompok.
            </p>
        </div>
        <div class="text-right">
            <div class="text-3xl font-black text-emerald-200">Rp {{ number_format($stats['kas_penjualan'], 0, ',', '.') }}</div>
            <a href="{{ route('admin.kas.index') }}" class="inline-block mt-2 text-xs font-bold text-white bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl transition">
                Buka Jurnal Kas →
            </a>
        </div>
    </div>

    <!-- TWO COLUMN: RECENT ORDERS & LOW STOCK -->
    <div class="grid lg:grid-cols-12 gap-8">
        <!-- RECENT ORDERS -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-black text-base text-gray-900">Pesanan Masuk Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">Semua Pesanan →</a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="py-12 text-center text-gray-400 text-xs">Belum ada pesanan masuk.</div>
            @else
                <div class="divide-y divide-gray-100 text-xs">
                    @foreach($recentOrders as $ro)
                    <div class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between">
                        <div>
                            <div class="font-bold text-gray-900">#{{ $ro->order_code }} - <span class="font-normal text-gray-600">{{ $ro->user->name }}</span></div>
                            <div class="text-[11px] text-gray-400">{{ $ro->created_at->diffForHumans() }} &bull; {{ $ro->orderItems->count() }} item sayur</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-black text-emerald-700">{{ $ro->formatted_total }}</span>
                            @php
                                $badges = [
                                    'unpaid' => 'bg-amber-100 text-amber-800',
                                    'pending' => 'bg-blue-100 text-blue-800',
                                    'paid' => 'bg-emerald-100 text-emerald-800',
                                    'rejected' => 'bg-rose-100 text-rose-800',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold {{ $badges[$ro->payment_status] ?? 'bg-gray-100' }}">
                                {{ ucfirst($ro->payment_status) }}
                            </span>
                            <a href="{{ route('admin.orders.show', $ro->id) }}" class="text-emerald-600 hover:underline font-bold">Periksa</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- LOW STOCK PRODUCTS -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h3 class="font-black text-base text-gray-900 mb-4">⚠️ Peringatan Stok Sayur</h3>
            @if($lowStockProducts->isEmpty())
                <div class="p-6 bg-emerald-50 text-emerald-800 rounded-2xl text-xs font-medium text-center">
                    ✅ Seluruh stok komoditas sayur masih dalam batas aman (> 10 satuan).
                </div>
            @else
                <div class="space-y-3">
                    @foreach($lowStockProducts as $lp)
                    <div class="p-3 bg-amber-50/70 rounded-2xl border border-amber-200/60 flex items-center justify-between text-xs">
                        <div>
                            <div class="font-bold text-gray-900">{{ $lp->name }}</div>
                            <div class="text-[11px] text-gray-500">{{ $lp->category->name }}</div>
                        </div>
                        <span class="font-mono font-bold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-lg">
                            Sisa: {{ $lp->stock }} {{ $lp->unit }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
