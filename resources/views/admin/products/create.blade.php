@extends('layouts.admin')
@section('title', 'Tambah Produk Sayur')
@section('page-title', 'Tambah Sayuran Baru')
@section('page-subtitle', 'Daftarkan hasil panen baru ke dalam katalog KWT Ariyad Jaya')
@section('content')
<div class="max-w-2xl bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kode Sayur</label>
                <input type="text" name="code" value="{{ old('code', 'PRD-' . rand(100, 999)) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-mono font-bold">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori</label>
                <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Sayuran</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold"
                placeholder="Contoh: Tomat Segar Merah">
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" required min="0"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold"
                    placeholder="Contoh: 8000">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Satuan</label>
                <input type="text" name="unit" value="{{ old('unit', 'kg') }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold"
                    placeholder="kg / ikat / pack">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Stok Fisik</label>
                <input type="number" name="stock" value="{{ old('stock', 10) }}" required min="0"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi & Keterangan</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 rounded-xl border border-gray-200 text-xs"
                placeholder="Deskripsi mutu, kesegaran panen...">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Unggah Foto Sayur</label>
            <input type="file" name="image" accept="image/*"
                class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white cursor-pointer">
        </div>

        <div class="pt-2">
            <label class="flex items-center space-x-2 text-xs font-bold text-gray-700 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="rounded text-emerald-600">
                <span>Tayangkan langsung di katalog web</span>
            </label>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">
                Simpan Produk
            </button>
            <a href="{{ route('admin.produk.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
