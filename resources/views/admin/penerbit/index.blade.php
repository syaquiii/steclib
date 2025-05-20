@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.penerbit.index') }}" class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-[#1F305E] text-4xl font-fraunces font-bold">Manajemen Penerbit</h2>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penerbit..."
                    class="px-4 py-2 border-2 border-[#805B4E] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1F305E] w-1/3">
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead class="bg-[#1F305E] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Alamat</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penerbits as $penerbit)
                        <tr class="border-b border-gray-300 hover:bg-gray-100 transition">
                            <td class="px-6 py-4">{{ $penerbit->id }}</td>
                            <td class="px-6 py-4">{{ $penerbit->nama }}</td>
                            <td class="px-6 py-4">{{ $penerbit->alamat }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.penerbit.edit', $penerbit->id) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center gap-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.penerbit.destroy', $penerbit->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus penerbit ini?')"
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
            {{ $penerbits->appends(['search' => request('search')])->links() }}
        </div>

        <!-- Add Button -->
        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.penerbit.create') }}"
                class="px-6 py-3 bg-[#1F305E] text-white rounded-lg hover:bg-[#142247] transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Penerbit
            </a>
        </div>
    </div>
@endsection