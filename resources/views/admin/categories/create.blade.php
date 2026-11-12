@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Sayuran')
@section('page-subtitle', 'Buat pengelompokan baru untuk etalase produk')
@section('content')
<div class="max-w-md bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Kategori</label>
            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold" placeholder="Contoh: Sayuran Buah">
        </div>
        <div class="pt-2 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">Simpan</button>
            <a href="{{ route('admin.kategori.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">Batal</a>
        </div>
    </form>
</div>
@endsection
