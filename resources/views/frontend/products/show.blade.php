@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-6 flex items-center space-x-2 text-xs font-semibold text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-emerald-600">Produk</a>
        <span>/</span>
        <span class="text-gray-700">{{ $product->name }}</span>
    </div>

    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm grid md:grid-cols-12 gap-10">
        <div class="md:col-span-5">
            <div class="aspect-square rounded-2xl bg-emerald-50 flex items-center justify-center overflow-hidden border border-emerald-100">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-8xl">🍅</span>
                @endif
            </div>
        </div>

        <div class="md:col-span-7 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    {{ $product->category->name }}
                </div>
                <h1 class="text-3xl font-black text-gray-900">{{ $product->name }}</h1>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-emerald-700">{{ $product->formatted_price }}</span>
                    <span class="text-sm text-gray-400 font-medium">/ {{ $product->unit }}</span>
                </div>

                <div class="py-2 border-y border-gray-100 flex items-center gap-6 text-xs text-gray-600">
                    <div>Kode Produk: <strong class="font-mono text-gray-800">{{ $product->code }}</strong></div>
                    <div>Stok Tersedia: <strong class="{{ $product->stock > 5 ? 'text-emerald-700' : 'text-amber-600' }}">{{ $product->stock }} {{ $product->unit }}</strong></div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description ?: 'Sayuran segar berkualitas tinggi hasil panen asli kebun petani KWT Ariyad Jaya Desa Purwodadi.' }}</p>
                </div>
            </div>

            <div class="pt-8 mt-6 border-t border-gray-100">
                @auth
                    @if($product->isAvailable())
                        <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="w-28">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1">Jumlah</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-center font-bold text-sm focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div class="flex-1 pt-5">
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-emerald-200 text-sm">
                                    🛒 Masukkan ke Keranjang Belanja
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-4 bg-gray-100 rounded-2xl text-center text-sm font-bold text-gray-500">
                            Mohon maaf, stok sayur ini sedang kosong.
                        </div>
                    @endif
                @else
                    <div class="p-4 bg-emerald-50 rounded-2xl flex items-center justify-between">
                        <span class="text-xs text-emerald-900 font-medium">Ingin memesan sayuran ini?</span>
                        <a href="{{ route('login') }}" class="text-xs font-bold bg-emerald-600 text-white px-4 py-2 rounded-xl">Masuk Akun</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
