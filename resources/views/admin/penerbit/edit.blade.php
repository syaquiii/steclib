@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold mb-6">Edit Penerbit</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.penerbit.update', $penerbit->id) }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">ID</label>
                <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-200"
                    value="{{ $penerbit->id }}" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Nama Penerbit</label>
                <input type="text" name="nama" value="{{ old('nama', $penerbit->nama) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('nama') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Alamat</label>
                <textarea name="alamat"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>{{ old('alamat', $penerbit->alamat) }}</textarea>
                @error('alamat') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.penerbit.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection