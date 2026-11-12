@extends('layouts.app')
@section('title', 'Sesi Kedaluwarsa')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-gray-100 shadow-xl text-center space-y-5">
        <div class="w-20 h-20 bg-amber-50 text-amber-600 rounded-3xl flex items-center justify-center text-4xl mx-auto shadow-inner">
            ⏳
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900">Sesi Halaman Berakhir</h1>
            <p class="text-xs text-gray-500 mt-2">
                Halaman ini telah terbuka terlalu lama sehingga token keamanan telah kedaluwarsa demi melindungi akun Anda.
            </p>
        </div>
        <div class="pt-2 flex flex-col gap-2">
            <a href="{{ route('login') }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3 rounded-xl transition text-xs shadow-md shadow-emerald-200">
                🔄 Muat Ulang Halaman Masuk
            </a>
            <a href="{{ route('home') }}" class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold py-2.5 rounded-xl transition text-xs border border-gray-200">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

