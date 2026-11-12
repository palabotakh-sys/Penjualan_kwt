@extends('layouts.app')
@section('title', 'Daftar Pesanan')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-black text-gray-900 mb-8">📋 Riwayat Pesanan Saya</h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm">
            <span class="text-6xl inline-block mb-3">📦</span>
            <h3 class="text-xl font-bold text-gray-800">Belum Ada Transaksi</h3>
            <p class="text-xs text-gray-500 mt-1">Anda belum pernah melakukan pemesanan sayur di KWT Ariyad Jaya.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-2xl text-sm transition">
                Mulai Berbelanja →
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $ord)
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-xs font-bold text-gray-400">#{{ $ord->order_code }}</span>
                        <span class="text-xs text-gray-400">&bull; {{ $ord->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="font-extrabold text-base text-gray-900 mt-1">
                        {{ $ord->orderItems->count() }} Macam Sayuran
                    </div>
                    <div class="text-xs text-gray-500 mt-0.5">
                        Tujuan: {{ Str::limit($ord->shipping_address, 45) }}
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-xs text-gray-400">Total Tagihan</div>
                        <div class="font-black text-emerald-700 text-base">{{ $ord->formatted_total }}</div>
                    </div>

                    @php
                        $badges = [
                            'unpaid' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Belum Bayar'],
                            'pending' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Verifikasi'],
                            'paid' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Lunas'],
                            'rejected' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-800', 'label' => 'Ditolak'],
                        ];
                        $badge = $badges[$ord->payment_status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => $ord->payment_status];
                    @endphp
                    <span class="px-3 py-1.5 rounded-xl text-xs font-extrabold {{ $badge['bg'] }} {{ $badge['text'] }}">
                        {{ $badge['label'] }}
                    </span>

                    <a href="{{ route('orders.show', $ord->order_code) }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-emerald-600 hover:text-white text-xs font-bold transition">
                        Detail →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
