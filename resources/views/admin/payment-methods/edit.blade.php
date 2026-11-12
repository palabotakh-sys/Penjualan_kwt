@extends('layouts.admin')
@section('title', 'Edit Rekening')
@section('page-title', 'Edit Rekening Pembayaran')
@section('page-subtitle', 'Perbarui data rekening tujuan transfer')
@section('content')
<div class="max-w-md bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
    <form action="{{ route('admin.rekening.update', $method->id) }}" method="POST" class="space-y-4">
        @csrf @method('PATCH')
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Bank / E-Wallet</label>
            <input type="text" name="bank_name" value="{{ old('bank_name', $method->bank_name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nomor Rekening</label>
            <input type="text" name="account_number" value="{{ old('account_number', $method->account_number) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-mono font-bold">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Atas Nama</label>
            <input type="text" name="account_holder" value="{{ old('account_holder', $method->account_holder) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold">
        </div>
        <div>
            <label class="flex items-center space-x-2 text-xs font-bold text-gray-700 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $method->is_active ? 'checked' : '' }} class="rounded text-emerald-600">
                <span>Rekening Aktif</span>
            </label>
        </div>
        <div class="pt-2 flex gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition">Perbarui</button>
            <a href="{{ route('admin.rekening.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl text-xs transition">Batal</a>
        </div>
    </form>
</div>
@endsection
