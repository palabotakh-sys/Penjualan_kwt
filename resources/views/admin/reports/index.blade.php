@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan & Keuangan')
@section('page-subtitle', 'Rekapitulasi pendapatan penjualan produk sayuran untuk 44 anggota KWT')
@section('content')
<div class="space-y-6">
    <!-- FILTER PERIODE -->
    <form method="GET" action="{{ route('admin.reports.index') }}" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $start }}" class="px-4 py-2 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $end }}" class="px-4 py-2 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition">
            🔍 Tampilkan Laporan
        </button>
        <a href="{{ route('admin.reports.export', ['start_date' => $start, 'end_date' => $end]) }}" target="_blank" class="bg-gray-800 hover:bg-gray-900 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition">
            🖨️ Cetak / Print PDF
        </a>
    </form>

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-emerald-100 shadow-sm">
            <div class="text-xs font-bold text-emerald-600 uppercase">Total Omzet Penjualan (Lunas)</div>
            <div class="text-2xl font-black text-emerald-950 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-1">{{ $totalOrders }} Nota transaksi terverifikasi</div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-blue-100 shadow-sm">
            <div class="text-xs font-bold text-blue-600 uppercase">Pemasukan Kas Periode Ini</div>
            <div class="text-2xl font-black text-blue-950 mt-1">Rp {{ number_format($kasIn, 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Penjualan + Iuran masuk</div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm">
            <div class="text-xs font-bold text-rose-600 uppercase">Pengeluaran Operasional</div>
            <div class="text-2xl font-black text-rose-950 mt-1">Rp {{ number_format($kasOut, 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Biaya produksi kebun</div>
        </div>
    </div>

    <!-- TABEL TRANSAKSI -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 font-extrabold text-sm text-gray-900">
            Daftar Transaksi Penjualan Lunas
        </div>
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">No. Transaksi</th>
                    <th class="p-4">Pembeli</th>
                    <th class="p-4">Rincian Sayuran</th>
                    <th class="p-4 text-right">Nilai Transaksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @forelse($orders as $ord)
                <tr>
                    <td class="p-4 font-mono">{{ $ord->created_at->format('d/m/Y') }}</td>
                    <td class="p-4 font-mono font-bold text-gray-900">#{{ $ord->order_code }}</td>
                    <td class="p-4">{{ $ord->user->name }}</td>
                    <td class="p-4 text-gray-600">
                        @foreach($ord->orderItems as $item)
                            <span>{{ $item->product->name }} ({{ $item->quantity }}){{ !$loop->last ? ', ' : '' }}</span>
                        @endforeach
                    </td>
                    <td class="p-4 text-right font-black text-emerald-700">{{ $ord->formatted_total }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-400">Tidak ada transaksi lunas pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
