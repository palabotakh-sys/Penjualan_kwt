@extends('layouts.admin')
@section('title', 'Rekening Pembayaran')
@section('page-title', 'Rekening Resmi KWT')
@section('page-subtitle', 'Daftar rekening tujuan transfer pembeli untuk setiap transaksi')
@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="font-extrabold text-base text-gray-900">Rekening Tujuan Transfer</h3>
        <a href="{{ route('admin.rekening.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition">
            + Tambah Rekening
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Bank / E-Wallet</th>
                    <th class="p-4">Nomor Rekening</th>
                    <th class="p-4">Atas Nama</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @foreach($methods as $m)
                <tr>
                    <td class="p-4 font-bold text-gray-900">{{ $m->bank_name }}</td>
                    <td class="p-4 font-mono font-bold text-emerald-700">{{ $m->account_number }}</td>
                    <td class="p-4 text-gray-600">{{ $m->account_holder }}</td>
                    <td class="p-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $m->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ $m->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.rekening.edit', $m->id) }}" class="text-emerald-600 hover:underline font-bold">Edit</a>
                        <form action="{{ route('admin.rekening.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rekening ini?')">
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
