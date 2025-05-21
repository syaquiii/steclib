@extends('layouts.app')

<x-navbar />

@section('content')
    <section class="bg-[#EEE7D5] min-h-screen py-40 px-40">
        <div class="px-20 flex gap-24 font-fraunces text-ourblue">
            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku {{ $book->judul }}"
                class="rounded-xl shadow-2xl w-1/4">
            <div>
                <h1 class="text-5xl">{{ $book->judul }}</h1>
                <p class="mt-4">-{{ $book->pengarang }}-</p>
                <p class="mt-4 font-segoe text-black">{{ $book->tagline }}</p>
                <div>
                    <div>
                        @auth
                            <div class="mt-8">
                                @if($existingLoan)
                                    <p class="text-white rounded-xl font-semibold bg-green-400 w-fit px-8 py-2">Anda sudah meminjam
                                        buku ini!</p>
                                @else
                                    <form action="{{ route('peminjaman.store', $book->isbn) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-ourblue text-white px-16 py-2 mt-4 rounded-lg hover:scale-110 transition-all">
                                            Pinjam 📚
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-block bg-ourblue text-white px-16 py-2 mt-4 rounded-lg hover:scale-110 transition-all">
                                Login untuk Pinjam
                            </a>
                        @endauth
                    </div>
                    <div>
                        @auth
    <div class="mt-4">
        @if ($bookInWishlist)
            <p class="text-white bg-yellow-500 px-8 py-2 rounded-xl w-fit font-semibold">
                Buku ini sudah ada di wishlist Anda 📌
            </p>
        @else
            <form action="{{ route('wishlist.quickAdd', $book->isbn) }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-yellow-500 text-white px-16 py-2 mt-2 rounded-lg hover:scale-110 transition-all">
                    Tambahkan ke Wishlist ⭐
                </button>
            </form>
        @endif
    </div>
@endauth
                    </div>
                </div>
            </div>
        </div>
        <!-- WHITE SPACE -->
        <div class="w-full px-20 py-32 min-h-[40rem] gap-16 bg-white grid grid-cols-2 rounded-2xl shadow-2xl -mt-10">
            <div>
                <h4 class="text-2xl font-fraunces text-ourblue font-bold mb-2">Sinopsis</h4>
                <p class="text-xs text-justify">{{ $book->sinopsis }}</p>
                <h4 class="mt-8 text-2xl font-fraunces text-ourblue font-bold">Review</h4>
                <div class="h-[15rem] overflow-y-scroll relative p-1 flex  flex-col  gap-10">
                    @foreach($reviewsOnIsbn as $review)
                        @include ('components.review-card')
                    @endforeach
                </div>
                @auth
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-ourblue">Tambahkan Review</h3>

                        {{-- Show error if user has already submitted a review --}}
                        @if(session('error'))
                            <p class="text-red-600 font-semibold">{{ session('error') }}</p>
                        @endif

                        {{-- Show success message --}}
                        @if(session('success'))
                            <p class="text-green-600 font-semibold">{{ session('success') }}</p>
                        @endif

                        <form action="{{ route('reviews.store') }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="isbn" value="{{ $book->isbn }}">

                            {{-- Input Review --}}
                            <div class="relative w-full h-fit flex items-center justify-between">
                                <textarea name="review" rows="2" class="w-4/5 p-3 border border-[#805B4E] rounded-md pr-12"
                                    placeholder="Tulis review Anda..." required></textarea>

                                {{-- Tombol Kirim dengan Ikon --}}
                                <button type="submit w-1/5 h-fit "
                                    class=" top-2 right-2 bg-[#805B4E] h-14 w-14 text-white p-3 rounded-full transition-all">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <p class="text-sm text-red-600 mt-2">
                        Anda harus <a href="{{ route('login') }}" class="underline text-blue-600">login</a> untuk menambahkan
                        review.
                    </p>
                @endauth
            </div>
            <div>
                <div class="mb-8">
                    <h4 class="text-2xl font-bold font-fraunces text-ourblue">Pengarang</h4>
                    <span>{{ $book->pengarang }}</span>
                </div>
                <div class="mb-8">
                    <h4 class="text-2xl font-bold font-fraunces text-ourblue">Penerbit</h4>
                    <span>{{ $book->penerbit->nama }}</span>
                </div>
                <div class="mb-8">
                    <h4 class="text-2xl font-bold font-fraunces text-ourblue">ISBN</h4>
                    <span>{{ $book->isbn }}</span>
                </div>
                <div class="mb-8">
                    <h4 class="text-2xl font-bold font-fraunces text-ourblue">Tahun Terbit</h4>
                    <span>{{ $book->tahun_terbit }}</span>
                </div>
                <h4 class="text-2xl font-bold font-fraunces text-ourblue mb-8">Buku Dengan Penerbit yang sama</h4>

                <div class="grid grid-cols-4 gap-4">
                    @foreach ($relatedBooks as $buku)
                        <a href="{{ route('books.show', $buku->isbn) }}">
                            @include('components.trending-books-card', ['buku' => $buku])
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection