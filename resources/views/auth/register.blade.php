@extends('layouts.app')
@section('title', 'Daftar Akun Baru')
@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
        <div class="text-center mb-6">
            <span class="text-5xl inline-block mb-3">🧺</span>
            <h2 class="text-2xl font-black text-gray-900">Pendaftaran Pembeli</h2>
            <p class="text-xs text-gray-500 mt-1">Beli sayuran segar langsung dari petani desa</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Nama Lengkap Anda">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Aktif</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="email@domain.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp / HP</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="08123456789">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Domisili</label>
                <textarea name="address" rows="2"
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Alamat tempat tinggal / pengiriman...">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kata Sandi</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Minimal 8 karakter">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ulangi Kata Sandi</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="Konfirmasi password">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-emerald-200 text-sm mt-2">
                Daftar Akun Baru ✓
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
