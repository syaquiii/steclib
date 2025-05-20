@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold mb-6">Tambah Penerbit</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.penerbit.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Nama Penerbit</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('nama') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Alamat</label>
                <textarea name="alamat"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>{{ old('alamat') }}</textarea>
                @error('alamat') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.penerbit.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection