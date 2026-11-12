@extends('layouts.app')
@section('title', 'Masuk Akun')
@section('content')
<div class="max-w-md mx-auto my-14 px-4">
    <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-xl shadow-emerald-900/5">
        <div class="text-center mb-8">
            <span class="text-5xl inline-block mb-3">🌿</span>
            <h2 class="text-2xl font-black text-gray-900">Masuk Sistem</h2>
            <p class="text-xs text-gray-500 mt-1">KWT Ariyad Jaya Desa Purwodadi</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="email@contoh.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kata Sandi</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-emerald-200 text-sm">
                Masuk Sekarang →
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-600">
                Belum memiliki akun pembeli?
                <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:underline">Daftar Di Sini</a>
            </p>
        </div>

        <!-- DEMO BADGE -->
        <div class="mt-6 p-4 rounded-2xl bg-emerald-50/70 border border-emerald-100 text-[11px] text-emerald-900">
            <div class="font-extrabold mb-1">🔑 Akun Demo Siap Login:</div>
            <div class="space-y-0.5 font-mono text-[10.5px]">
                <div>• Ketua: <strong>ketua@ariyadjaya.com</strong> (pass: <em>password</em>)</div>
                <div>• Bendahara: <strong>bendahara@ariyadjaya.com</strong> (pass: <em>password</em>)</div>
                <div>• Customer: <strong>pembeli@gmail.com</strong> (pass: <em>password</em>)</div>
            </div>
        </div>
    </div>
</div>
@endsection
