@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('page-title', 'Daftar Pesanan Sayur')
@section('page-subtitle', 'Verifikasi bukti transfer bank dan perbarui status pengiriman')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Kode Transaksi</th>
                    <th class="p-4">Nama Pelanggan</th>
                    <th class="p-4">Total Bayar</th>
                    <th class="p-4">Pembayaran</th>
                    <th class="p-4">Status Pesanan</th>
                    <th class="p-4">Tanggal Order</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @forelse($orders as $ord)
                <tr class="hover:bg-gray-50/50">
                    <td class="p-4 font-mono font-bold text-gray-900">#{{ $ord->order_code }}</td>
                    <td class="p-4">
                        <div class="font-bold text-gray-900">{{ $ord->user->name }}</div>
                        <div class="text-[10px] text-gray-400">{{ $ord->customer_phone }}</div>
                    </td>
                    <td class="p-4 font-black text-emerald-700">{{ $ord->formatted_total }}</td>
                    <td class="p-4">
                        @php
                            $badges = [
                                'unpaid' => 'bg-amber-100 text-amber-800',
                                'pending' => 'bg-blue-100 text-blue-800',
                                'paid' => 'bg-emerald-100 text-emerald-800',
                                'rejected' => 'bg-rose-100 text-rose-800',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold {{ $badges[$ord->payment_status] ?? 'bg-gray-100' }}">
                            {{ ucfirst($ord->payment_status) }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 capitalize">
                            {{ $ord->order_status }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-400 text-[11px]">{{ $ord->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.orders.show', $ord->id) }}" class="bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-xl font-bold transition">
                            Detail & Konfirmasi →
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-400">Belum ada data transaksi pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $orders->links() }}</div>
</div>
@endsection
