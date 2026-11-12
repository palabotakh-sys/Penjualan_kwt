@extends('layouts.app')
@section('title', 'Katalog Sayur')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900">🥬 Katalog Sayuran Segar</h1>
        <p class="text-sm text-gray-500 mt-1">Pilih sayuran bermutu tinggi langsung dari hasil panen KWT Ariyad Jaya</p>
    </div>

    <!-- FILTER & SEARCH -->
    <form method="GET" action="{{ route('products.index') }}" class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm mb-10 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Cari Sayur</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Contoh: Tomat, Sawi..."
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori</label>
            <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Urutan Harga</label>
            <select name="sort" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm">
                <option value="">Terbaru</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Termurah</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Termahal</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                🔍 Filter
            </button>
            @if(request()->hasAny(['search', 'category', 'sort']))
                <a href="{{ route('products.index') }}" class="px-3.5 py-2.5 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-xl text-sm font-bold transition">
                    ✕
                </a>
            @endif
        </div>
    </form>

    <!-- PRODUCT GRID -->
    @if($products->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center border border-gray-100">
            <span class="text-6xl inline-block mb-3">🔍</span>
            <h3 class="text-lg font-bold text-gray-800">Tidak ada produk ditemukan</h3>
            <p class="text-xs text-gray-500 mt-1">Coba sesuaikan kata kunci pencarian atau kategori Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $prod)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all p-4 flex flex-col justify-between group">
                <div>
                    <a href="{{ route('products.show', $prod->slug) }}" class="block w-full aspect-square rounded-2xl bg-emerald-50/60 overflow-hidden mb-3.5 relative">
                        @if($prod->image)
                            <img src="{{ asset('storage/'.$prod->image) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl">🥬</div>
                        @endif
                        <span class="absolute top-2 left-2 text-[10px] font-bold bg-white/90 backdrop-blur text-emerald-800 px-2.5 py-0.5 rounded-full shadow-sm">
                            {{ $prod->category->name }}
                        </span>
                    </a>
                    <h3 class="font-extrabold text-base text-gray-900 group-hover:text-emerald-600 transition leading-snug">
                        <a href="{{ route('products.show', $prod->slug) }}">{{ $prod->name }}</a>
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $prod->description }}</p>
                    <div class="mt-2 text-xs font-semibold {{ $prod->stock > 5 ? 'text-gray-400' : 'text-amber-600' }}">
                        Sisa Stok: {{ $prod->stock }} {{ $prod->unit }}
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="font-black text-base text-emerald-700">{{ $prod->formatted_price }}</div>
                        <div class="text-[10px] text-gray-400">per {{ $prod->unit }}</div>
                    </div>
                    @auth
                        @if($prod->isAvailable())
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-md shadow-emerald-200">
                                    + Keranjang
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 font-bold px-3 py-1.5 bg-gray-100 rounded-lg">Habis</span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-xl hover:bg-emerald-100 transition">
                            Beli →
                        </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
