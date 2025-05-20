@extends('layouts.app')

@section('content')

    <section class="flex justify-between bg-[#EEE7D5] h-screen w-screen">
        <div class="w-2/3 flex font-fraunces gap-y-4 flex-col justify-center items-center">
            <h4 class="text-5xl font-bold text-[#1F305E]">Sign Up</h4>
            <span class="text-[#1F305E]">Masuk dan mulai jelajahi koleksi buku kami.</span>

            <form class="grid grid-cols-1 gap-4 w-1/3 place-items-center" action="{{ route('register') }}" method="POST">
                @csrf
                <input class="bg-[#F6F4F1] p-2 rounded-lg w-full" type="text" name="username" value="{{ old('username') }}"
                    required placeholder="username">
                @error('username')
                    <span class="text-red-500 text-xs w-full text-left">{{ $message }}</span>
                @enderror

                <input class="bg-[#F6F4F1] p-2 rounded-lg w-full" type="text" name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}" required placeholder="fullname">
                @error('nama_lengkap')
                    <span class="text-red-500 text-xs w-full text-left">{{ $message }}</span>
                @enderror

                <input class="bg-[#F6F4F1] p-2 rounded-lg w-full" type="email" name="email" value="{{ old('email') }}"
                    required placeholder="email">
                @error('email')
                    <span class="text-red-500 text-xs w-full text-left">{{ $message }}</span>
                @enderror

                <input class="bg-[#F6F4F1] p-2 rounded-lg w-full" type="password" name="password" required
                    placeholder="password">
                @error('password')
                    <span class="text-red-500 text-xs w-full text-left">{{ $message }}</span>
                @enderror

                <input class="bg-[#F6F4F1] p-2 rounded-lg w-full" type="password" name="password_confirmation" required
                    placeholder="confirm password">

                <button class="bg-[#1F305E] text-white rounded-xl w-full py-2" type="submit">Register</button>

                <div class="text-sm text-[#1F305E] w-full">
                    Already have an account? <a href="{{ route('login') }}" class="underline">Login here</a>
                </div>
            </form>

            @if ($errors->any())
                <div class="text-red-500 w-1/3">
                    @foreach ($errors->all() as $error)
                        <div class="text-sm">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="w-1/3 h-full">
            <img class="h-full w-full object-cover" src="{{ asset('images/regis.png') }}" alt="Register Image">
        </div>
    </section>
@endsection