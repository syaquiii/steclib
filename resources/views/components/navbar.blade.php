<nav class="container w-full items-center fixed z-20 left-0 right-0 px-40 py-10">
    <div class="flex w-full justify-between items-center">
        <div class="flex gap-20 font-fraunces">
            <h1 class="text-4xl font-bold text-[#1F305E]">Steclib.</h1>
            <ul class="flex gap-10 items-center">
                <li class="{{ Request::is('/') ? 'text-[#1F305E] border-b-2 font-bold border-b-[#1F305E]' : '' }}">
                    Beranda</li>
                <li>Daftar Buku</li>
                <li>Daftar Pinjaman</li>
                <li>Wishlist</li>
            </ul>
        </div>
        <div>
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">
                    <button>Login</button>
                </a>
            @endif
        </div>

    </div>
</nav>