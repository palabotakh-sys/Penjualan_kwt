@extends('layouts.admin')
@section('title', 'Pengaturan QRIS Payment Gateway')
@section('page-title', 'Pengaturan QRIS Payment Gateway')
@section('page-subtitle', 'Integrasi QRIS Dinamis (DANA Bisnis, GoPay, E-Wallet & M-Banking) via EMVCo / BuatQRIS')
@section('content')
<div class="space-y-8">
    <!-- INFO BANNER -->
    <div class="bg-gradient-to-r from-emerald-800 to-green-700 text-white rounded-3xl p-6 shadow-md shadow-emerald-950/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-2xl">⚡</span>
                <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-200">Sistem QRIS Dinamis Otomatis</span>
            </div>
            <h2 class="text-xl font-black text-white mt-1">Cukup Tempel String QRIS DANA Bisnis / E-Wallet Anda</h2>
            <p class="text-xs text-emerald-100/90 mt-1 max-w-2xl leading-relaxed">
                Sistem akan secara otomatis menyisipkan nominal belanja tiap pesanan (Tag 54) dan menghitung ulang checksum CRC16. Pembeli tidak perlu mengetik nominal lagi saat scan QRIS.
            </p>
        </div>
        <div class="bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/20 text-center min-w-[180px]">
            <div class="text-[11px] text-emerald-200 font-bold uppercase">Status Gateway</div>
            <div class="text-lg font-black text-white mt-0.5">{{ $qrisEnabled === '1' ? '🟢 AKTIF' : '⚪ NONAKTIF' }}</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-8 items-start">
        <!-- FORM PENGATURAN -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm space-y-6">
            <h3 class="font-black text-base text-gray-900 pb-3 border-b border-gray-100 flex items-center gap-2">
                <span>⚙️</span> Konfigurasi String QRIS
            </h3>

            <form action="{{ route('admin.qris.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- ACTIVE TOGGLE -->
                <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-center justify-between">
                    <div>
                        <div class="font-extrabold text-xs text-emerald-950">Aktifkan Metode QRIS Dinamis</div>
                        <div class="text-[11px] text-gray-500">Tampilkan opsi bayar QRIS saat pelanggan checkout pesanan</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="qris_enabled" value="1" {{ $qrisEnabled === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <!-- NAMA MERCHANT -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        Nama Merchant / Toko <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="qris_merchant_name" value="{{ old('qris_merchant_name', $merchantName) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: KWT ARIYAD JAYA">
                    <p class="text-[11px] text-gray-400 mt-1">Nama usaha yang akan tampil saat pelanggan scan QRIS.</p>
                </div>

                <!-- STRING QRIS STATIS -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1 flex items-center justify-between">
                        <span>String QRIS Statis Anda <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-emerald-600 font-mono">Format: 000201...</span>
                    </label>
                    <textarea name="qris_static_string" rows="5" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 font-mono text-xs focus:ring-2 focus:ring-emerald-500 leading-relaxed"
                        placeholder="00020101021126590014ID.DANA.WWW...">{{ old('qris_static_string', $staticString) }}</textarea>
                    <p class="text-[11px] text-gray-500 mt-1">
                        Salin teks kode QR dari DANA Bisnis, GoPay Merchant, BCA, atau bank Anda, lalu tempelkan di kotak ini.
                    </p>
                </div>

                <!-- OPSIONAL: BUATQRIS API URL -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        URL API BuatQRIS (Opsional / Cadangan)
                    </label>
                    <input type="url" name="buatqris_api_url" value="{{ old('buatqris_api_url', $buatqrisUrl) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-mono focus:ring-2 focus:ring-emerald-500"
                        placeholder="https://app.buatqris.site/api">
                    <p class="text-[11px] text-gray-400 mt-1">
                        Default menggunakan engine EMVCo bawaan sistem (100% instan, tanpa kuota & tanpa ketergantungan server luar).
                    </p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 rounded-xl text-xs transition shadow-lg shadow-emerald-200">
                        💾 Simpan Pengaturan Gateway
                    </button>
                </div>
            </form>

            <!-- TUTORIAL BANTUAN -->
            <div class="mt-8 pt-6 border-t border-gray-100 space-y-3">
                <h4 class="font-extrabold text-xs text-gray-900 uppercase">📖 Cara Mendapatkan String QRIS DANA Bisnis / E-Wallet</h4>
                <ol class="list-decimal list-inside text-xs text-gray-600 space-y-1.5 leading-relaxed">
                    <li>Buka aplikasi <strong>DANA Bisnis</strong>, <strong>GoPay Merchant</strong>, atau <strong>Mobile Banking</strong> Anda.</li>
                    <li>Unduh atau tangkap layar (*screenshot*) gambar barcode QRIS Anda.</li>
                    <li>Buka <strong>Google Lens</strong> di HP atau situs web pembaca QR (seperti <em>webqr.com</em> atau <em>zxing.org</em>).</li>
                    <li>Arahkan ke gambar barcode QRIS Anda untuk membaca teks mentahnya.</li>
                    <li>Salin string teks yang dihasilkan (pasti diawali dengan kode <code>000201010211...</code>).</li>
                    <li>Tempelkan string tersebut ke kotak formulir di atas dan simpan.</li>
                </ol>
            </div>
        </div>

        <!-- PREVIEW & LIVE SIMULATOR -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="font-black text-base text-gray-900 flex items-center gap-1.5">
                        <span>📱</span> Simulator QRIS Live
                    </h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                        Uji Scan
                    </span>
                </div>

                <!-- TEST AMOUNT FORM -->
                <form method="GET" action="{{ route('admin.qris.index') }}" class="flex items-center gap-2">
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Uji Coba Nominal</label>
                        <input type="number" name="test_amount" value="{{ $testAmount }}" min="1000" step="1000"
                            class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-bold text-emerald-800 font-mono">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-3 py-2 rounded-xl text-xs transition">
                            Generate
                        </button>
                    </div>
                </form>

                @if($previewData && $previewData['is_configured'])
                    <div class="p-6 bg-gradient-to-b from-emerald-50/50 to-white rounded-2xl border border-emerald-100 text-center space-y-3">
                        <div class="text-xs font-bold text-emerald-950 uppercase tracking-wider">
                            {{ $previewData['merchant_name'] }}
                        </div>
                        <div class="text-2xl font-black text-emerald-700">
                            {{ $previewData['formatted_amount'] }}
                        </div>
                        <div class="w-60 h-60 mx-auto bg-white p-3 rounded-2xl border border-gray-200 shadow-sm">
                            <img src="{{ $previewData['qr_url'] }}" alt="QRIS Live" class="w-full h-full object-contain">
                        </div>
                        <div class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            ✨ Scan dengan DANA / GoPay / M-Banking Anda
                        </div>
                        <p class="text-[10px] text-gray-400">
                            Nominal {{ $previewData['formatted_amount'] }} akan otomatis terisi saat discan.
                        </p>
                    </div>

                    <!-- RAW DYNAMIC STRING PREVIEW -->
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-[10px]">
                        <div class="font-bold text-gray-500 mb-1 flex items-center justify-between">
                            <span>String QRIS Dinamis (Hasil Generasi):</span>
                            <span class="font-mono text-emerald-600">{{ strlen($previewData['payload']) }} Karakter</span>
                        </div>
                        <div class="font-mono text-gray-700 break-all select-all bg-white p-2 rounded border border-gray-200 max-h-24 overflow-y-auto">
                            {{ $previewData['payload'] }}
                        </div>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-400 text-xs">
                        Masukkan dan simpan string QRIS terlebih dahulu untuk melihat preview live.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

