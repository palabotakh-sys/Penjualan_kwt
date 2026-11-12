@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Anggota / Pengguna')
@section('page-subtitle', 'Perbarui data akun pengguna')
@section('content')
<div class="max-w-md bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf @method('PATCH')
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Role / Peran</label>
            <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
                <option value="anggota" {{ $user->role === 'anggota' ? 'selected' : '' }}>Anggota KWT Ariyad Jaya</option>
                <option value="bendahara" {{ $user->role === 'bendahara' ? 'selected' : '' }}>Bendahara KWT</option>
                <option value="ketua" {{ $user->role === 'ketua' ? 'selected' : '' }}>Ketua KWT</option>
                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer / Pembeli</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ganti Kata Sandi (Kosongkan bila tidak diubah)</label>
            <input type="password" name="password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="Minimal 8 karakter">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div class="pt-2 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">Perbarui</button>
            <a href="{{ route('admin.pengguna.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">Batal</a>
        </div>
    </form>
</div>
@endsection
