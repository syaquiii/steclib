@extends('layouts.app')

<x-navbar />

@section('content')
    <section class="bg-[#EEE7D5] max-w-full h-full  relative ">
        <div class="flex justify-between w-full ">
            {{-- Left Content --}}
            <div class="w-3/5 py-30   pl-40 pr-20 ">
                {{-- Heading Section --}}
                <h1 class="text-6xl font-fraunces w-3/4 text-[#1F305E]">
                    Rekomendasi Bacaan Hari Ini
                </h1>
                <p class="mt-4 w-4/5 text-[#1F305E] text-sm">
                    Sedang mencari bacaan seru atau ingin menambah wawasan? Jangan ragu
                    untuk meminjam buku dari koleksiku! Ada banyak pilihan menarik yang bisa menemani waktu luangmu.
                    Yuk, eksplorasi cerita dan ilmu baru bersama!
                </p>

                {{-- CTA Button --}}
                <button onclick="window.location.href='{{ route('books.daftar') }}'"
                    class="mt-10 bg-ourblue text-white px-4 py-2 rounded-xl hover:scale-105 cursor-pointer hover:bg-blue-950 transition-all">
                    Mulai Meminjam
                </button>

                {{-- Trending Section --}}
                {{-- Section Trending --}}
                <div class="mt-10 w-full">
                    <h2 class="text-2xl font-fraunces text-ourblue mb-4">Trending</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($trending as $buku)
                            <a href="{{ route('books.show', $buku->isbn) }}">
                                @include('components.trending-books-card', ['buku' => $buku])
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Section Buku Baru Terbit --}}
                <div class="mt-10   ">
                    <h2 class="text-2xl font-fraunces text-ourblue mb-4">Baru Terbit</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($bukuBaru as $buku)
                            <a href="{{ route('books.show', $buku->isbn) }}">
                                @include('components.trending-books-card', ['buku' => $buku])
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Right Content (optional) --}}
            <div class="w-2/5 relative pr-24 bg-[#F6F4F1] py-30">
                {{-- Placeholder content --}}
                <div class=" h-full ">
                    <img class="absolute top-8 -left-[15rem]" src="{{ asset('images/buku.png') }}" alt="">
                    <!-- BEST BOOKS -->
                    <div class="pl-48 pr-20">

                        @if($bestBook)
                            @include('components.best-book', ['buku' => $bestBook])
                        @else
                            <p>Tidak ada buku terbaik saat ini.</p>
                        @endif
                    </div>
                    <!-- REVIEWS -->
                    <div class="mt-10 pl-20 pr-10 pt-32 h-screen ">
                        <h2 class="text-2xl font-fraunces text-ourblue mb-4">Review Terbaru</h2>
                        <div class="h-[30rem] overflow-y-scroll relative p-1 flex  flex-col  gap-10" style="scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach($reviews as $review)
                                @include ('components.review-card')
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <x-footer />
@endsection