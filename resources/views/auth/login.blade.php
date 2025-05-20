@extends('layouts.app')

@section('content')
    <section class="flex justify-between bg-[#EEE7D5] h-screen w-screen">
        <!-- Image on the LEFT side -->
        <div class="w-1/3 h-full">
            <img class="h-full w-full object-cover" src="{{ asset('images/login.png') }}" alt="Login Image">
        </div>

        <!-- Login form on the RIGHT side -->
        <div class="w-2/3 flex font-fraunces gap-y-4 flex-col justify-center items-center">
            <h4 class="text-5xl font-bold text-[#1F305E]">Log in</h4>
            <span class="text-[#1F305E]">Masuk dan lanjutkan petualangan membaca Anda.</span>

            <form class="grid grid-cols-1 gap-4 w-1/3 place-items-center" action="{{ route('login') }}" method="POST">
                @csrf
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



                <button class="bg-[#1F305E] text-white rounded-xl w-full py-2" type="submit">Login</button>

                <div class="text-sm text-[#1F305E] w-full">
                    Don't have an account? <a href="{{ route('register') }}" class="underline">Register here</a>
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
    </section>
@endsection