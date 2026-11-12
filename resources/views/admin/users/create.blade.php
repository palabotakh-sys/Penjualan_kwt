@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Anggota / Pengguna')
@section('page-subtitle', 'Daftarkan pengurus, anggota KWT, atau pembeli')
@section('content')
<div class="max-w-md bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="Nama lengkap">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="email@domain.com">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Role / Peran</label>
            <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
                <option value="anggota">Anggota KWT Ariyad Jaya</option>
                <option value="bendahara">Bendahara KWT</option>
                <option value="ketua">Ketua KWT</option>
                <option value="customer">Customer / Pembeli</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp</label>
            <input type="text" name="phone_number" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="08123456789">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kata Sandi</label>
            <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="Minimal 8 karakter">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div class="pt-2 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">Simpan Pengguna</button>
            <a href="{{ route('admin.pengguna.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">Batal</a>
        </div>
    </form>
</div>
@endsection
