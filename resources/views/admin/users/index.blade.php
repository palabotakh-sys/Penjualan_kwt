@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Data Anggota & Pengguna')
@section('page-subtitle', 'Daftar 44 anggota Kelompok Wanita Tani Ariyad Jaya serta akun pembeli')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="font-extrabold text-base text-gray-900">Total Pengguna Terdaftar</h3>
        <a href="{{ route('admin.pengguna.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition">
            + Tambah Anggota / User Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase font-bold text-[10px]">
                <tr>
                    <th class="p-4">Nama Lengkap</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">No. HP</th>
                    <th class="p-4">Peran (Role)</th>
                    <th class="p-4">Tanggal Gabung</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @foreach($users as $u)
                <tr>
                    <td class="p-4 font-bold text-gray-900">{{ $u->name }}</td>
                    <td class="p-4 text-gray-500">{{ $u->email }}</td>
                    <td class="p-4 font-mono">{{ $u->phone_number ?: '-' }}</td>
                    <td class="p-4">
                        @php
                            $roles = [
                                'ketua' => 'bg-purple-100 text-purple-800',
                                'bendahara' => 'bg-amber-100 text-amber-800',
                                'anggota' => 'bg-emerald-100 text-emerald-800',
                                'customer' => 'bg-gray-100 text-gray-700',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold capitalize {{ $roles[$u->role] ?? 'bg-gray-100' }}">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-400">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('admin.pengguna.edit', $u->id) }}" class="text-emerald-600 hover:underline font-bold">Edit</a>
                        @if($u->id !== auth()->id())
                        <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:underline font-bold">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
