@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
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


        <form method="GET" action="{{ route('admin.user.index') }}" class="mb-6">
            <div class="flex items=center justify-between">
                <h2 class="text-[#1F305E] text-4x1 font-fraunces font-bold">Manajemen Anggota</h2>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota..."
                    class="px=4 py-2 border-2 border-[#805B4E] rounded-1g focus:outline-none focus:ring-2 focus:ring-[#1F305E] w-1/3">
            </div>
        </form>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full border-collapse">
                <thead class="bg-[#1F305E] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Username</th>
                        <th class="px-6 py-3 text-left">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Jumlah Peminjaman</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-300 hover:bg-gray-100 transition">
                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->nama_lengkap }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->peminjamans_count }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.user.edit', ['user' => $user->username]) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center gap-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->username) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus anggota ini?')"
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

        {{ $users->appends(request()->query())->links() }}

        <div class="mt-6 flex justify-center">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>

        <div class="mt-6 flex justify-center">
            <a href="{{ route('admin.user.create') }}"
                class="px-4 py-2 bg-[#1F305E] text-white rounded-lg hover:bg-[#805B4E] transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Anggota
            </a>
        </div>
    </div>
@endsection