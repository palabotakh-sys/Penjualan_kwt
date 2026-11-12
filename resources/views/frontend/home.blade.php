@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<!-- HERO SECTION -->
<section class="relative overflow-hidden bg-gradient-to-b from-emerald-800 via-emerald-700 to-green-600 text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur border border-white/20 text-xs font-semibold text-emerald-100">
                    <span>🌱</span> Sayuran Petani Asli Purwodadi
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15]">
                    Sayuran Segar <span class="text-emerald-300 underline decoration-emerald-400">Dipetik Hari Ini</span>, Langsung ke Rumah Anda.
                </h1>
                <p class="text-base sm:text-lg text-emerald-100/90 leading-relaxed max-w-xl">
                    Produk sayuran pilihan binaan <strong>Kelompok Wanita Tani (KWT) Ariyad Jaya</strong>. Tanpa perantara, bebas bahan kimia berbahaya, dijamin segar dan menyehatkan keluarga.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('products.index') }}" class="bg-white text-emerald-900 font-extrabold px-8 py-3.5 rounded-2xl shadow-xl hover:bg-emerald-50 transition transform hover:-translate-y-0.5">
                        🛒 Mulai Belanja Sayur
                    </a>
                    <a href="#profil-kwt" class="bg-emerald-900/40 border border-white/20 text-white font-bold px-6 py-3.5 rounded-2xl hover:bg-emerald-900/60 transition">
                        Profil Organisasi
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div>
                            <div class="text-xs uppercase text-emerald-200 font-semibold tracking-wider">Mitra Produksi</div>
                            <div class="text-xl font-black text-white">KWT Ariyad Jaya</div>
                        </div>
                        <div class="text-3xl">🧺</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 p-4 rounded-2xl">
                            <div class="text-2xl font-black text-emerald-300">44</div>
                            <div class="text-xs text-emerald-100 font-medium">Anggota Petani Wanita</div>
                        </div>
                        <div class="bg-white/10 p-4 rounded-2xl">
                            <div class="text-2xl font-black text-emerald-300">100%</div>
                            <div class="text-xs text-emerald-100 font-medium">Sayuran Alami Lokal</div>
                        </div>
                        <div class="bg-white/10 p-4 rounded-2xl">
                            <div class="text-2xl font-black text-emerald-300">Dusun 1</div>
                            <div class="text-xs text-emerald-100 font-medium">Desa Purwodadi</div>
                        </div>
                        <div class="bg-white/10 p-4 rounded-2xl">
                            <div class="text-2xl font-black text-emerald-300">2022</div>
                            <div class="text-xs text-emerald-100 font-medium">Tahun Didirikan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KATALOG UNGGULAN -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
        <div>
            <span class="text-xs font-bold text-emerald-600 tracking-wider uppercase">Pilihan Hari Ini</span>
            <h2 class="text-3xl font-black text-gray-900 mt-1">Katalog Sayuran Segar</h2>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 mt-3 md:mt-0 flex items-center gap-1">
            Lihat Semua Sayur →
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
        @forelse($featuredProducts as $prod)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all p-4 flex flex-col justify-between group">
            <div>
                <div class="w-full aspect-square rounded-2xl bg-emerald-50/60 flex items-center justify-center overflow-hidden mb-3.5 relative">
                    @if($prod->image)
                        <img src="{{ asset('storage/'.$prod->image) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    @else
                        <span class="text-5xl">🍅</span>
                    @endif
                    <span class="absolute top-2 left-2 text-[10px] font-bold bg-white/90 backdrop-blur text-emerald-800 px-2 py-0.5 rounded-full shadow-sm">
                        {{ $prod->category->name }}
                    </span>
                </div>
                <h3 class="font-extrabold text-sm text-gray-900 group-hover:text-emerald-600 transition leading-snug">
                    <a href="{{ route('products.show', $prod->slug) }}">{{ $prod->name }}</a>
                </h3>
                <div class="mt-1 text-xs text-gray-400 font-medium">Stok: {{ $prod->stock }} {{ $prod->unit }}</div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs text-gray-400">Harga:</div>
                    <div class="font-black text-sm text-emerald-700">{{ $prod->formatted_price }}</div>
                </div>
                <a href="{{ route('products.show', $prod->slug) }}" class="w-8 h-8 rounded-xl bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-700 flex items-center justify-center font-bold text-sm transition" title="Lihat Detail">
                    +
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-400">
            Belum ada produk yang ditampilkan saat ini.
        </div>
        @endforelse
    </div>
</section>

<!-- PROFIL KWT SECTION -->
<section id="profil-kwt" class="bg-white border-y border-emerald-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-5">
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Mengenal Kelompok Tani</span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                    Pemberdayaan Wanita Tani di Dusun 1 Purwodadi
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Kelompok Wanita Tani (KWT) Ariyad Jaya berdiri pada awal tahun 2022 di Dusun 1 Desa Purwodadi, Kecamatan Trimurjo, Kabupaten Lampung Tengah. Dipimpin oleh <strong>Ibu Sumini</strong>, kelompok tani ini kini merangkul 44 orang anggota yang aktif membudidayakan sayuran segar seperti tomat, sawi, terong, dan cabai.
                </p>
                <div class="grid sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
                        <div class="text-2xl mb-1">🌿</div>
                        <div class="font-extrabold text-sm text-gray-900">Tanpa Perantara</div>
                        <div class="text-xs text-gray-500 mt-0.5">Penjualan langsung dari kebun memberi harga lebih adil bagi petani dan konsumen.</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
                        <div class="text-2xl mb-1">📊</div>
                        <div class="font-extrabold text-sm text-gray-900">Pembukuan Transparan</div>
                        <div class="text-xs text-gray-500 mt-0.5">Pemisahan tertib antara kas penjualan produk dan iuran anggota KWT.</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-tr from-emerald-100 to-green-50 rounded-3xl p-8 border border-emerald-200 text-center space-y-4">
                <span class="text-6xl inline-block">👩‍🌾</span>
                <h3 class="text-xl font-black text-emerald-950">Kelompok Wanita Tani (KWT) Ariyad Jaya</h3>
                <p class="text-xs text-emerald-800 leading-relaxed max-w-sm mx-auto">
                    "Memajukan kesejahteraan keluarga petani melalui sayuran segar berdaya saing tinggi dan pemanfaatan sistem informasi penjualan modern."
                </p>
                <div class="pt-4 border-t border-emerald-200/60 flex justify-center gap-6 text-xs font-bold text-emerald-900">
                    <div>📍 Desa Purwodadi</div>
                    <div>👥 44 Petani</div>
                    <div>📅 Est. 2022</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
