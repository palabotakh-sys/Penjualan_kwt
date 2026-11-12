<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KWT Ariyad Jaya') - Sayuran Segar Desa Purwodadi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-50/30 text-gray-800 min-h-screen flex flex-col antialiased">
    <!-- TOP NOTIFICATION -->
    <div class="bg-emerald-800 text-emerald-100 text-xs py-1.5 px-4 text-center font-medium">
        🌱 Panen Segar Setiap Hari Langsung dari Petani KWT Ariyad Jaya &bull; Dusun 1 Purwodadi, Trimurjo, Lampung Tengah
    </div>

    <!-- MAIN NAVBAR -->
    <header class="bg-white/95 backdrop-blur shadow-sm sticky top-0 z-50 border-b border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-green-500 flex items-center justify-center text-2xl shadow-md shadow-emerald-200 group-hover:scale-105 transition">
                        🌿
                    </div>
                    <div>
                        <div class="font-extrabold text-xl text-emerald-950 tracking-tight leading-none">KWT ARIYAD JAYA</div>
                        <div class="text-xs font-semibold text-emerald-600 tracking-wider uppercase mt-1">Desa Purwodadi</div>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-semibold text-sm {{ request()->routeIs('home') ? 'text-emerald-700' : 'text-gray-600 hover:text-emerald-600' }} transition">Beranda</a>
                    <a href="{{ route('products.index') }}" class="font-semibold text-sm {{ request()->routeIs('products.*') ? 'text-emerald-700' : 'text-gray-600 hover:text-emerald-600' }} transition">Katalog Sayur</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-sm text-amber-700 bg-amber-50 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition">⚙️ Panel Pengurus</a>
                        @endif
                        <a href="{{ route('cart.index') }}" class="relative font-semibold text-sm text-gray-700 hover:text-emerald-600 transition flex items-center gap-1.5">
                            <span>🛒 Keranjang</span>
                            @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                            @if($cartCount > 0)
                                <span class="bg-emerald-600 text-white text-[11px] font-bold px-1.5 py-0.5 rounded-full">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('orders.index') }}" class="font-semibold text-sm text-gray-600 hover:text-emerald-600 transition">Pesanan Saya</a>
                        
                        <div class="border-l border-gray-200 pl-6 flex items-center space-x-3">
                            <div class="text-right">
                                <div class="text-xs font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</div>
                                <div class="text-[10px] text-emerald-600 capitalize font-medium">{{ auth()->user()->role }}</div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs bg-gray-100 hover:bg-red-50 hover:text-red-600 text-gray-600 font-bold px-3 py-1.5 rounded-lg transition" title="Keluar">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-emerald-700 px-4 py-2 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl shadow-md shadow-emerald-200 transition">Daftar Akun</a>
                        </div>
                    @endauth
                </nav>

                <!-- Mobile menu button -->
                <button id="mobile-btn" class="md:hidden text-gray-700 p-2 text-2xl focus:outline-none">☰</button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block font-semibold py-2 text-gray-700">Beranda</a>
            <a href="{{ route('products.index') }}" class="block font-semibold py-2 text-gray-700">Katalog Sayur</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block font-semibold py-2 text-amber-700">⚙️ Panel Pengurus</a>
                @endif
                <a href="{{ route('cart.index') }}" class="block font-semibold py-2 text-gray-700">🛒 Keranjang Belanja</a>
                <a href="{{ route('orders.index') }}" class="block font-semibold py-2 text-gray-700">Pesanan Saya</a>
                <form action="{{ route('logout') }}" method="POST" class="pt-2 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="w-full text-left font-bold text-red-600 py-2">Keluar ({{ auth()->user()->name }})</button>
                </form>
            @else
                <div class="pt-2 border-t border-gray-100 grid grid-cols-2 gap-2">
                    <a href="{{ route('login') }}" class="text-center font-bold py-2.5 rounded-xl bg-gray-100 text-gray-700">Masuk</a>
                    <a href="{{ route('register') }}" class="text-center font-bold py-2.5 rounded-xl bg-emerald-600 text-white">Daftar</a>
                </div>
            @endauth
        </div>
    </header>

    <!-- FLASH MESSAGES -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-2xl flex items-center justify-between mb-3 shadow-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-xl">✅</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-300 text-rose-900 px-4 py-3 rounded-2xl flex items-center justify-between mb-3 shadow-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-xl">⚠️</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @if(isset($errors) && $errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-900 px-4 py-3 rounded-2xl mb-3 shadow-sm">
                <div class="font-bold text-xs uppercase mb-1">Terjadi Kesalahan:</div>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- MAIN BODY -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-emerald-950 text-white mt-20 border-t border-emerald-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <span class="text-3xl">🌿</span>
                    <div>
                        <div class="font-extrabold text-xl text-white">KWT ARIYAD JAYA</div>
                        <div class="text-xs text-emerald-400 font-semibold tracking-wider uppercase">Desa Purwodadi &bull; Lampung Tengah</div>
                    </div>
                </div>
                <p class="text-sm text-emerald-200/80 leading-relaxed max-w-md">
                    Wadah kelompok wanita tani beranggotakan 44 orang di Dusun 1 Desa Purwodadi, Kecamatan Trimurjo, Kabupaten Lampung Tengah. Berdedikasi memproduksi sayuran segar berkualitas tinggi langsung dari kebun binaan masyarakat.
                </p>
                <div class="mt-4 flex items-center gap-2 text-xs text-emerald-300">
                    <span class="px-2.5 py-1 rounded-full bg-emerald-900/80 border border-emerald-800">44 Anggota Tani</span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-900/80 border border-emerald-800">Ketua: Ibu Sumini</span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-900/80 border border-emerald-800">Berdiri Sejak 2022</span>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-emerald-300 text-sm tracking-wider uppercase mb-4">Menu Navigasi</h4>
                <ul class="space-y-2.5 text-sm text-emerald-100/70">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Katalog Produk</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Login Anggota / Pengurus</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Pendaftaran Pembeli</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-emerald-300 text-sm tracking-wider uppercase mb-4">Sekretariat KWT</h4>
                <p class="text-sm text-emerald-100/80 leading-relaxed">
                    Dusun 1, Desa Purwodadi, Kec. Trimurjo, Kab. Lampung Tengah, Lampung.
                </p>
                <div class="mt-3 text-sm text-emerald-200">
                    <div>📞 WhatsApp: <strong>0812-3456-7890</strong></div>
                    <div class="mt-1">🏦 Rekening BRI: <strong>5678-01-023456-53-1</strong></div>
                </div>
            </div>
        </div>

        <div class="border-t border-emerald-900 py-6 text-center text-xs text-emerald-400">
            &copy; {{ date('Y') }} KWT Ariyad Jaya Desa Purwodadi. Perancangan Sistem Informasi Penjualan Produk Berbasis Web.
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-btn');
        const menu = document.getElementById('mobile-menu');
        if(btn && menu) {
            btn.addEventListener('click', () => menu.classList.toggle('hidden'));
        }
    </script>
</body>
</html>
