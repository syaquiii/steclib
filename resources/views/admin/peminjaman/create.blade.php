@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold mb-6">Tambah Peminjaman</h2>

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <select name="username"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                    <option value="">-- Pilih Pengguna --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->username }}" {{ old('username') == $user->username ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
                @error('username') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">ISBN Buku</label>
                <select name="isbn"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->isbn }}" {{ old('isbn') == $book->isbn ? 'selected' : '' }}>
                            {{ $book->judul }} ({{ $book->isbn }})
                        </option>
                    @endforeach
                </select>
                @error('isbn') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tanggal_pinjam') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none">
                @error('tanggal_kembali') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection