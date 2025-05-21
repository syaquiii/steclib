@extends('layouts.app')
<x-navbar />

@section('content')
    <div class="p-40">
        <h1 class="mb-6 text-3xl font-bold text-[#1F305E]">My Wishlist</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" data-bs-dismiss="alert"
                    aria-label="Close">
                    &times;
                </button>
            </div>
        @endif

        @if($wishlists->isEmpty())
            <div class=" text-blue-800 p-4 rounded-md text-center">
                Your wishlist is empty.
            </div>
        @else
            <div class="overflow-hidden ">
                <table class="w-full table-auto  rounded-md">
                    <thead class=" text-brown-custom">
                        <tr>
                            <th class="p-4 text-left">Cover</th>
                            <th class="p-4 text-left">Book Details</th>
                            <th class="p-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlists as $wishlist)
                            <tr class="  transition-all">
                                <td class="p-4">
                                    <img src="{{ asset('storage/' . $wishlist->buku->cover) }}" alt="{{ $wishlist->buku->judul }}"
                                        class="w-24 h-32 object-cover rounded-lg shadow-md">
                                </td>
                                <td class="p-4">
                                    <h5 class="text-xl font-semibold">{{ $wishlist->buku->judul }}</h5>
                                    <p class="text-gray-600 text-sm">ISBN: {{ (string) $wishlist->isbn }}</p>
                                    <p class="text-gray-700">{{ $wishlist->buku->pengarang }}</p>
                                    <p class="text-gray-500">{{ $wishlist->buku->penerbit->nama }}
                                        ({{ $wishlist->buku->tahun_terbit }})
                                    </p>
                                    <p class="text-sm px-2 py-1 rounded-md bg-ourblue text-white inline-block mt-2">Wishlist Item
                                    </p>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('books.show', $wishlist->isbn) }}"
                                            class="px-4 py-2 bg-blue-600 w-full flex justify-center items-center gap-2 text-white rounded-md shadow-md hover:bg-blue-700 transition">
                                            <i class="fas fa-info-circle"></i> View Details
                                        </a>
                                        <form action="{{ route('wishlists.destroy', $wishlist->isbn) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 w-full bg-red-600 text-white rounded-md shadow-md hover:bg-red-700 transition">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection