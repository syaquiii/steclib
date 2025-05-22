@extends('admin.layout.app')

@section('content')
    <div class="container p-6 rounded-lg">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('isbn') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('judul') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Cover</label>
                <div class="flex items-start space-x-4">
                    <div class="flex-1">
                        <input type="file" name="cover" id="cover-upload" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                            required>
                        <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG, GIF. Maks: 2MB</p>
                        @error('cover') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="w-40">
                        <div
                            class="border border-gray-300 rounded-lg h-40 w-32 flex items-center justify-center overflow-hidden">
                            <img id="cover-preview" src="{{ asset('img/no-image.png') }}" alt="Cover Preview"
                                class="max-h-full max-w-full">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('pengarang') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Penerbit</label>
                <select name="id_penerbit"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                    <option value="">-- Pilih Penerbit --</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}" {{ old('id_penerbit') == $publisher->id ? 'selected' : '' }}>
                            {{ $publisher->nama }}
                        </option>
                    @endforeach
                </select>
                @error('id_penerbit') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1900"
                    max="{{ date('Y') + 1 }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tahun_terbit') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>
                @error('tagline') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Sinopsis</label>
                <textarea name="sinopsis" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>{{ old('sinopsis') }}</textarea>
                @error('sinopsis') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-[#1F305E] font-semibold mb-2">Konten</label>
                <textarea name="konten" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1F305E] focus:outline-none"
                    required>{{ old('konten') }}</textarea>
                @error('konten') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.buku.index') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const coverUpload = document.getElementById('cover-upload');
            const coverPreview = document.getElementById('cover-preview');

            // Check if the elements exist in the DOM
            if (coverUpload && coverPreview) {
                coverUpload.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            coverPreview.src = e.target.result;
                        }

                        reader.readAsDataURL(this.files[0]);
                    } else {
                        coverPreview.src = "{{ asset('img/no-image.png') }}";
                    }
                });

                // Log to check that event listener is attached
                console.log('Image preview functionality initialized');
            } else {
                console.error('Cover upload or preview elements not found');
            }
        });
    </script>
@endpush