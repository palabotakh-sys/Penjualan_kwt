@extends('layouts.admin')
@section('title', 'Tambah Rekening')
@section('page-title', 'Tambah Rekening Pembayaran')
@section('page-subtitle', 'Masukkan nomor rekening resmi KWT')
@section('content')
<div class="max-w-md bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.rekening.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Bank / E-Wallet</label>
            <input type="text" name="bank_name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="Contoh: Bank BRI">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nomor Rekening</label>
            <input type="text" name="account_number" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-mono font-bold" placeholder="5678-01-xxxxxx-xx-x">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Atas Nama</label>
            <input type="text" name="account_holder" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="KWT ARIYAD JAYA">
        </div>
        <div class="pt-2 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">Simpan Rekening</button>
            <a href="{{ route('admin.rekening.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">Batal</a>
        </div>
    </form>
</div>
@endsection
