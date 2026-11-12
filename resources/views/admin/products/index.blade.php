@extends('layouts.admin')
@section('title', 'Kelola Produk Sayur')
@section('page-title', 'Kelola Produk Sayur')
@section('page-subtitle', 'Manajemen katalog produk sayuran segar KWT Ariyad Jaya')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.produk.index') }}" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sayur..."
                class="px-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500">
            <select name="category" class="px-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-4 py-2 rounded-xl text-xs">Cari</button>
        </form>

        <a href="{{ route('admin.produk.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs shadow-md shadow-emerald-200 transition">
            + Tambah Sayuran Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Foto</th>
                    <th class="p-4">Kode & Nama</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga / Satuan</th>
                    <th class="p-4">Stok</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @forelse($products as $p)
                <tr class="hover:bg-gray-50/50">
                    <td class="p-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center overflow-hidden">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl">🥬</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-gray-900">{{ $p->name }}</div>
                        <div class="text-[10px] text-gray-400 font-mono">{{ $p->code }}</div>
                    </td>
                    <td class="p-4"><span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold">{{ $p->category->name }}</span></td>
                    <td class="p-4 font-bold text-emerald-700">{{ $p->formatted_price }} / {{ $p->unit }}</td>
                    <td class="p-4"><span class="font-bold {{ $p->stock <= 5 ? 'text-amber-600' : 'text-gray-700' }}">{{ $p->stock }} {{ $p->unit }}</span></td>
                    <td class="p-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $p->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $p->is_active ? 'Tayang' : 'Draft' }}
                        </span>
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.produk.edit', $p->id) }}" class="text-emerald-600 hover:underline font-bold">Edit</a>
                        <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-400">Belum ada produk yang didaftarkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $products->links() }}</div>
</div>
@endsection
