@extends('layouts.admin')
@section('title', 'Kategori Sayuran')
@section('page-title', 'Kategori Sayuran')
@section('page-subtitle', 'Pengelompokan jenis produk sayur segar')
@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="font-extrabold text-base text-gray-900">Daftar Kategori</h3>
        <a href="{{ route('admin.kategori.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Nama Kategori</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4">Jumlah Produk</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @foreach($categories as $c)
                <tr>
                    <td class="p-4 font-bold text-gray-900">{{ $c->name }}</td>
                    <td class="p-4 font-mono text-gray-400">{{ $c->slug }}</td>
                    <td class="p-4"><span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold">{{ $c->products_count }} Sayur</span></td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.kategori.edit', $c->id) }}" class="text-emerald-600 hover:underline font-bold">Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
