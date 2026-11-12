@extends('layouts.admin')
@section('title', 'Edit Mutasi Kas')
@section('page-title', 'Edit Catatan Mutasi Kas')
@section('page-subtitle', 'Perbarui data mutasi kas iuran atau pengeluaran operasional')
@section('content')
<div class="max-w-xl bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.kas.update', $mutation->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tipe Mutasi</label>
                <select name="transaction_type" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
                    <option value="in" {{ $mutation->transaction_type === 'in' ? 'selected' : '' }}>▲ Pemasukan (Uang Masuk)</option>
                    <option value="out" {{ $mutation->transaction_type === 'out' ? 'selected' : '' }}>▼ Pengeluaran (Uang Keluar)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Transaksi</label>
                <input type="date" name="transaction_date"
                    value="{{ $mutation->transaction_date instanceof \Carbon\Carbon ? $mutation->transaction_date->format('Y-m-d') : $mutation->transaction_date }}"
                    required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori Kas</label>
            <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
                <option value="penjualan_produk" {{ $mutation->category === 'penjualan_produk' ? 'selected' : '' }}>Penjualan Produk Sayuran</option>
                <option value="iuran_anggota" {{ $mutation->category === 'iuran_anggota' ? 'selected' : '' }}>Kas Iuran Anggota Kelompok</option>
                <option value="operasional" {{ $mutation->category === 'operasional' ? 'selected' : '' }}>Biaya Operasional Kebun / Panen</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nominal (Rp)</label>
            <input type="number" name="amount" required min="1000"
                value="{{ $mutation->amount }}"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold"
                placeholder="Contoh: 50000">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keterangan Catatan</label>
            <textarea name="description" rows="3"
                class="w-full px-4 py-2 rounded-xl border border-gray-200 text-xs"
                placeholder="Penjelasan sumber kas atau tujuan pengeluaran...">{{ $mutation->description }}</textarea>
        </div>

        @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('admin.kas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

