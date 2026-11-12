@extends('layouts.admin')
@section('title', 'Detail Sayur: ' . $product->name)
@section('page-title', 'Detail Produk Sayur')
@section('page-subtitle', 'Informasi lengkap komoditas panen')
@section('content')
<div class="max-w-2xl bg-white rounded-3xl p-8 border border-gray-100 shadow-sm space-y-6">
    <div class="flex items-center space-x-6">
        <div class="w-32 h-32 rounded-2xl bg-emerald-50 flex items-center justify-center overflow-hidden border border-emerald-100">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover">
            @else
                <span class="text-5xl">🥬</span>
            @endif
        </div>
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                {{ $product->category->name }}
            </span>
            <h2 class="text-2xl font-black text-gray-900 mt-2">{{ $product->name }}</h2>
            <div class="text-xs text-gray-400 font-mono mt-0.5">Kode: {{ $product->code }}</div>
            <div class="text-lg font-black text-emerald-700 mt-1">{{ $product->formatted_price }} / {{ $product->unit }}</div>
        </div>
    </div>

    <div class="border-t border-gray-100 pt-4 space-y-3 text-xs">
        <div><strong class="text-gray-400 uppercase">Stok Tersedia:</strong> <span class="font-bold text-gray-800">{{ $product->stock }} {{ $product->unit }}</span></div>
        <div><strong class="text-gray-400 uppercase">Status:</strong> <span class="font-bold text-gray-800">{{ $product->is_active ? 'Aktif Tayang' : 'Nonaktif' }}</span></div>
        <div><strong class="text-gray-400 uppercase">Deskripsi:</strong> <p class="text-gray-600 mt-1 leading-relaxed">{{ $product->description ?: 'Tidak ada deskripsi' }}</p></div>
    </div>

    <div class="border-t border-gray-100 pt-4 flex gap-3">
        <a href="{{ route('admin.produk.edit', $product->id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2 rounded-xl text-xs transition">
            Edit Data
        </a>
        <a href="{{ route('admin.produk.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-4 py-2 rounded-xl text-xs transition">
            Kembali
        </a>
    </div>
</div>
@endsection

