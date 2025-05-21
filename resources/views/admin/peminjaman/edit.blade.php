@extends('admin.layout.app')

@section('content')
    <div class="container p-6 rounded-lg">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

        <div class="mb-4">
            <label class="block text-[#1F305E] font-semibold mb-2">ID Peminjaman</label>
            <input type="text" name="id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-200"
                value="{{ $peminjaman->id }}" disabled>
        </div>

        <div class="mb-4">
            <label class="block text-[#1F305E] font-semibold mb-2">Username</label>
            <input type="text" name="username" value="{{ old('username', $peminjaman->username) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                required>
            @error('username') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-[#1F305E] font-semibold mb-2">ISBN Buku</label>
            <input type="text" name="judul" value="{{ old('isbn', $peminjaman->isbn) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                required>
            @error('isbn') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-[#1F305E] font-semibold mb-2">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                required>
            @error('tanggal_pinjam') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>