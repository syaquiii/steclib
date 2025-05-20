@extends('admin.layout.app')

@section('content')
    <div class="container bg-[#F6F4F1] p-6 rounded-lg shadow-lg">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
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
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-300 hover:bg-gray-100 transition">
                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->nama_lengkap }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
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