@extends('layouts.admin')
@section('title', 'Kas Penjualan KWT')
@section('page-title', 'Jurnal Kas Penjualan vs Iuran')
@section('page-subtitle', 'Pemisahan pencatatan keuangan omzet hasil panen dari kas iuran anggota kelompok')
@section('content')
<div class="space-y-6">
    <!-- SUMMARY KAS 3 KATEGORI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-emerald-100 shadow-sm">
            <div class="text-xs font-bold text-emerald-600 uppercase">Kas Hasil Penjualan Produk</div>
            <div class="text-2xl font-black text-emerald-950 mt-1">Rp {{ number_format($summary['penjualan'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Pemasukan langsung dari pesanan online</div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-blue-100 shadow-sm">
            <div class="text-xs font-bold text-blue-600 uppercase">Kas Iuran Anggota KWT</div>
            <div class="text-2xl font-black text-blue-950 mt-1">Rp {{ number_format($summary['iuran'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Iuran bulanan 44 anggota terpisah</div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-rose-100 shadow-sm">
            <div class="text-xs font-bold text-rose-600 uppercase">Pengeluaran Operasional</div>
            <div class="text-2xl font-black text-rose-950 mt-1">Rp {{ number_format($summary['operasional_keluar'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-1">Biaya bibit, pupuk, dan perawatan</div>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <h3 class="font-extrabold text-base text-gray-900">Riwayat Mutasi Kas</h3>
        <a href="{{ route('admin.kas.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition">
            + Catat Mutasi Kas Manual
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Kategori Kas</th>
                    <th class="p-4">Jenis</th>
                    <th class="p-4">Nominal</th>
                    <th class="p-4">Keterangan</th>
                    <th class="p-4">Pencatat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @forelse($mutations as $m)
                <tr class="hover:bg-gray-50/50">
                    <td class="p-4 font-mono">{{ $m->transaction_date->format('d/m/Y') }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $m->category === 'penjualan_produk' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $m->category_label }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="font-bold {{ $m->transaction_type === 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $m->transaction_type === 'in' ? '▲ Masuk' : '▼ Keluar' }}
                        </span>
                    </td>
                    <td class="p-4 font-black">{{ $m->formatted_amount }}</td>
                    <td class="p-4 text-gray-600">{{ $m->description }}</td>
                    <td class="p-4 text-gray-400">{{ $m->recorder->name ?? 'Sistem' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-400">Belum ada data pencatatan kas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
