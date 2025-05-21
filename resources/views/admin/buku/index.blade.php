@extends('admin.layout.app')

@section('content')
    <div class="container p-6 rounded-lg">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.buku.index') }}" class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold">Manajemen Buku</h2>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..."
                    class="px-4 py-2 border-2 border-[#805B4E] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1F305E] w-1/3">
            </div>
        </form>

        <div class="overflow-x-auto bg-[#F6F4F1] rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead class="bg-[#1F305E] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">ISBN</th>
                        <th class="px-6 py-3 text-left">Judul Buku</th>
                        <th class="px-6 py-3 text-left">Pengarang</th>
                        <th class="px-6 py-3 text-left">Penerbit</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bukus as $buku)
                        <tr class="border-b border-gray-300 hover:bg-gray-100 transition">
                            <td class="px-6 py-4">{{ $buku->isbn }}</td>
                            <td class="px-6 py-4">{{ $buku->judul }}</td>
                            <td class="px-6 py-4">{{ $buku->pengarang }}</td>
                            <td class="px-6 py-4">{{ $buku->penerbit->nama ?? 'Tidak diketahui' }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.buku.edit', $buku->isbn) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center gap-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.buku.destroy', $buku->isbn) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus buku ini?')"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition flex items-center gap-2">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $bukus->appends(['search' => request('search')])->links() }}
        </div>

        <!-- Add Button -->
        <div class="mt-6">
            <a href="{{ route('admin.buku.create') }}"
                class="px-6 py-3 bg-[#1F305E] text-white rounded-lg hover:bg-[#1F305E] transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i>Tambah Buku
            </a>
        </div>
    </div>
@endsection