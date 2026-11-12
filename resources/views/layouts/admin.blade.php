<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - KWT Ariyad Jaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-emerald-950 text-white min-h-screen flex-shrink-0 flex flex-col justify-between border-r border-emerald-900">
        <div>
            <!-- LOGO -->
            <div class="p-6 border-b border-emerald-900">
                <div class="flex items-center space-x-3">
                    <span class="text-3xl">🌿</span>
                    <div>
                        <div class="font-extrabold text-lg text-white leading-tight">KWT ARIYAD JAYA</div>
                        <div class="text-[11px] font-semibold text-emerald-400 tracking-wider uppercase">Sistem Penjualan</div>
                    </div>
                </div>
            </div>

            <!-- NAVIGATION -->
            <nav class="p-4 space-y-1.5 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">📊</span><span>Dashboard</span>
                </a>

                <div class="pt-3 pb-1 px-3 text-[11px] font-bold tracking-wider uppercase text-emerald-400">Master Data</div>
                
                <a href="{{ route('admin.produk.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.produk.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">🥬</span><span>Produk Sayur</span>
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.kategori.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">🏷️</span><span>Kategori</span>
                </a>

                <div class="pt-3 pb-1 px-3 text-[11px] font-bold tracking-wider uppercase text-emerald-400">Transaksi & Keuangan</div>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">📦</span><span>Pesanan Masuk</span>
                </a>
                @if(auth()->user()->isBendahara() || auth()->user()->isKetua())
                <a href="{{ route('admin.kas.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.kas.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">💰</span><span>Kas Penjualan vs Iuran</span>
                </a>
                <a href="{{ route('admin.rekening.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.rekening.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">🏦</span><span>Rekening KWT</span>
                </a>
                <a href="{{ route('admin.qris.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.qris.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">⚡</span><span>QRIS Gateway</span>
                </a>
                @endif
                <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">📋</span><span>Laporan Penjualan</span>
                </a>

                @if(auth()->user()->isKetua())
                <div class="pt-3 pb-1 px-3 text-[11px] font-bold tracking-wider uppercase text-emerald-400">Pengaturan</div>
                <a href="{{ route('admin.pengguna.index') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.pengguna.*') ? 'bg-emerald-600 text-white' : 'text-emerald-200/70 hover:bg-emerald-900/60 hover:text-white' }} transition">
                    <span class="text-lg">👥</span><span>Data Anggota & User</span>
                </a>
                @endif
            </nav>
        </div>

        <!-- USER FOOTER -->
        <div class="p-4 border-t border-emerald-900 bg-emerald-950/80">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="font-bold text-white text-xs leading-tight">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-emerald-400 capitalize">{{ auth()->user()->role }}</div>
                </div>
                <a href="{{ route('home') }}" target="_blank" class="text-xs bg-emerald-900 hover:bg-emerald-800 text-emerald-200 px-2 py-1 rounded font-medium" title="Buka Toko Web">
                    Toko ↗
                </a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-center text-xs bg-rose-950/60 hover:bg-rose-900 text-rose-300 font-bold py-2 rounded-lg transition">
                    🚪 Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="flex-1 flex flex-col min-h-screen overflow-y-auto">
        <!-- TOP BAR -->
        <header class="bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-gray-500 font-medium">@yield('page-subtitle', 'Panel Administrasi KWT Ariyad Jaya Desa Purwodadi')</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Role: <strong class="capitalize">{{ auth()->user()->role }}</strong>
                </span>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        <div class="px-8 pt-5">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-xl flex items-center space-x-2 shadow-sm mb-4">
                    <span>✅</span><span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-300 text-rose-900 px-4 py-3 rounded-xl flex items-center space-x-2 shadow-sm mb-4">
                    <span>⚠️</span><span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif
            @if(isset($errors) && $errors->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-900 px-4 py-3 rounded-xl shadow-sm mb-4">
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- MAIN VIEW -->
        <main class="flex-1 px-8 pb-12 pt-2">
            @yield('content')
        </main>
    </div>
</body>
</html>
