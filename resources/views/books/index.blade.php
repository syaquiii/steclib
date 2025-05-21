@extends('layouts.app')
<x-navbar />

@section('content')
<section class="px-40 py-40 min-h-screen">
    <div class=" h-fit mb-12">
        <h4 class="font-fraunces text-2xl font-bold text-ourblue mb-4">Populer</h4>
        <div class="grid grid-cols-6 gap-x-6  ">

            @foreach ($trending as $buku)
                <a href="{{ route('books.show', $buku->isbn) }}">
                    @include('components.trending-books-card', ['buku' => $buku])
                </a>
            @endforeach

        </div>
    </div>
    <div class=" h-fit">
        <h4 class="font-fraunces text-2xl font-bold text-ourblue mb-4">Baru Rilis nich</h4>
        <div class="grid grid-cols-6 gap-x-6  ">

            @foreach ($latestbooks as $buku)
                <a href="{{ route('books.show', $buku->isbn) }}">
                    @include('components.trending-books-card', ['buku' => $buku])
                </a>
            @endforeach

        </div>
    </div>
    <div class=" h-fit mt-8">
        <h4 class="font-fraunces text-2xl font-bold text-ourblue mb-4">Daftar Buku Lainnya</h4>
        <div class="grid grid-cols-6 gap-6  ">

            @foreach ($books as $buku)
                <a href="{{ route('books.show', $buku->isbn) }}">
                    @include('components.trending-books-card', ['buku' => $buku])
                </a>
            @endforeach

        </div>
    </div>

</section>