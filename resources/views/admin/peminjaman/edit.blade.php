@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold mb-6">Edit Peminjaman</h2>

        @if(session('success'))
            <div
                class="flex items-center justify-between p-4 mb-6 text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-sm">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <form action="{{ route('admin.peminjaman.update', $peminjaman->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Username</label>
                <select name="username"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                    <option value="">-- Pilih Pengguna --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->username }}" {{ old('username', $peminjaman->username) == $user->username ? 'selected' : '' }}>
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
                        <option value="{{ $book->isbn }}" {{ old('isbn', $peminjaman->isbn) == $book->isbn ? 'selected' : '' }}>
                            {{ $book->judul }} ({{ $book->isbn }})
                        </option>
                    @endforeach
                </select>
                @error('isbn') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tanggal_pinjam') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none">
                @error('tanggal_kembali') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tanggal Wajib Kembali</label>
                <input type="date" name="tanggal_wajib_kembali"
                    value="{{ old('tanggal_wajib_kembali', $peminjaman->tanggal_wajib_kembali) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tanggal_wajib_kembali') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection