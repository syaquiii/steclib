@extends('admin.layout.app')

@section('content')
    <div class="container p-6 rounded-lg">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.buku.update', $buku->isbn) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">ISBN</label>
                <input type="text" name="isbn" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-200"
                    value="{{ old('isbn', $buku->isbn) }}" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('judul') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            @php $isEdit = true; @endphp
            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Cover</label>
                <input type="file" name="cover"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    {{ isset($isEdit) && $isEdit ? '' : 'required' }}>
                @error('cover') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror

                @if(!empty($buku->cover))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover" class="w-24 h-auto rounded shadow">
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('pengarang') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">ID Penerbit</label>
                <input type="number" name="id_penerbit" value="{{ old('id_penerbit', $buku->id_penerbit) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('id_penerbit') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Sinopsis</label>
                <input type="text" name="sinopsis" value="{{ old('sinopsis', $buku->sinopsis) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('sinopsis') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $buku->tagline) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tagline') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <input type="hidden" name="konten" value="dummy-dulu">

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tahun Terbit</label>
                <input type="text" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tahun_terbit') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.buku.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection