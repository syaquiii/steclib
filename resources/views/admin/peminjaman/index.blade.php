@extends('admin.layout.app')

@section('content')
    <div class="container p-6 rounded-lg">
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


        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold">Peminjaman</h2>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..."
                    class="px-4 py-2 border-2 border-[#805B4E] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1F305E] w-1/3">
            </div>
        </form>

        <div class="overflow-x-auto bg-[#F6F4F1] rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead class="bg-[#1F305E] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">ID Anggota</th>
                        <th class="px-6 py-3 text-left">Nama Anggota</th>
                        <th class="px-6 py-3 text-left">Judul Buku</th>
                        <th class="px-6 py-3 text-left">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjamans as $peminjaman)
                        <tr class="border-b border-gray-300 hover:bg-gray-100 transition">
                            <td class="px-6 py-4">{{ $peminjaman->user->username ?? 'Tidak diketahui' }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->user->nama_lengkap ?? 'Tidak diketahui' }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->buku->judul ?? 'Tidak diketahui' }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->tanggal_pinjam }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.peminjaman.edit', $peminjaman->id) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center gap-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus peminjaman ini?')"
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

        <div class="mt-6 flex justify-center">
            {{ $peminjamans->appends(['search' => request('search')])->links() }}
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.peminjaman.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Peminjaman
            </a>
        </div>
    </div>
@endsection