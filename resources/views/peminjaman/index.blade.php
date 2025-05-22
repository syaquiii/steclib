@extends('layouts.app')
<x-navbar />
@section('content')
    <section class="container mx-auto px-40 py-20">
        <h1 class="text-3xl font-bold my-10">Buku Saya</h1>

        <!-- Active Borrowings -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Buku Yang Sedang Dipinjam</h2>

            @if($activePeminjamans->count() > 0)
                <div class="grid grid-cols-2 gap-2">

                    @foreach ($activePeminjamans as $peminjaman)
                        @include('components.daftar-pinjam', ['peminjaman' => $peminjaman])


                    @endforeach

                </div>

            @else
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <p class="text-gray-500">Anda tidak memiliki buku yang sedang dipinjam.</p>
                </div>
            @endif
        </div>

        <!-- Borrowing History -->
        <!-- Borrowing History -->
        <div>
            <h2 class="text-2xl font-semibold mb-4">Riwayat Peminjaman</h2>

            @if($historyPeminjamans->count() > 0)
                <div class="overflow-x-auto bg-white rounded-lg shadow ring-1 ring-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Judul Buku</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($historyPeminjamans as $peminjaman)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-ourblue font-medium">
                                        <a href="{{ route('books.show', $peminjaman->buku->isbn) }}" class="hover:underline">
                                            {{ $peminjaman->buku->judul }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $peminjaman->tanggal_pinjam->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $peminjaman->tanggal_kembali->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($peminjaman->tanggal_kembali->isAfter($peminjaman->tanggal_wajib_kembali))
                                            <span
                                                class="inline-flex items-center gap-1 text-xs px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 5.636l-12.728 12.728m0-12.728l12.728 12.728" />
                                                </svg>
                                                Terlambat
                                                {{ $peminjaman->tanggal_kembali->diffInDays($peminjaman->tanggal_wajib_kembali) }} hari
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 text-xs px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $historyPeminjamans->links('pagination::tailwind') }}
                </div>
            @else
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <p class="text-gray-500">Anda belum memiliki riwayat peminjaman buku.</p>
                </div>
            @endif
        </div>

    </section>
@endsection

@section('footer')
    <x-footer />
@endsection
<!--     
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
    
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    
        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif -->