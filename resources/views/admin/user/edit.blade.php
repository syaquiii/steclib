@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold mb-6">Edit Anggota</h2>
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

        <form action="{{ route('admin.user.update', $user->username) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Username</label>
                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-200"
                    value="{{ $user->username }}" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('nama_lengkap') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none">
                @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none">
                @error('password_confirmation') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Apakah Admin</label>
                <select name="is_admin"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none">
                    <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.user.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection