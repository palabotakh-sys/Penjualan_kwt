@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-black text-gray-900 mb-8">🛒 Keranjang Belanja Saya</h1>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm">
            <span class="text-6xl inline-block mb-3">🧺</span>
            <h3 class="text-xl font-bold text-gray-800">Keranjang Belanja Masih Kosong</h3>
            <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Silakan lihat katalog sayuran segar kami dan tambahkan produk yang Anda butuhkan.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-2xl text-sm transition">
                Jelajahi Produk Sayur →
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm divide-y divide-gray-100">
                @foreach($cartItems as $item)
                <div class="py-4 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-xl bg-emerald-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl">🥬</span>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-extrabold text-sm text-gray-900">{{ $item->product->name }}</h4>
                            <div class="text-xs text-gray-500">{{ $item->product->formatted_price }} / {{ $item->product->unit }}</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                class="w-16 px-2 py-1 border border-gray-200 rounded-lg text-center text-xs font-bold"
                                onchange="this.form.submit()">
                        </form>
                        <div class="text-right min-w-[90px]">
                            <div class="font-black text-sm text-emerald-700">{{ $item->formatted_subtotal }}</div>
                        </div>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-rose-600 text-sm p-1" title="Hapus">✕</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- TOTAL SUMMARY -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-5">
                <h3 class="font-black text-base text-gray-900 pb-3 border-b border-gray-100">Ringkasan Belanja</h3>
                <div class="flex justify-between text-xs text-gray-600">
                    <span>Total Item</span>
                    <span class="font-bold text-gray-900">{{ $cartItems->sum('quantity') }} Produk</span>
                </div>
                <div class="flex justify-between text-base font-black text-gray-900 pt-3 border-t border-gray-100">
                    <span>Total Tagihan:</span>
                    <span class="text-emerald-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-2xl shadow-lg shadow-emerald-200 transition text-sm">
                    Lanjut ke Pembayaran →
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
