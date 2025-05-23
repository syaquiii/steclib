<nav id="navbar" class="w-full items-center fixed   z-20 left-0 right-0 px-40 py-10 transition-all duration-300">

    <div class="flex w-full justify-between items-center">
        <div class="flex gap-20 font-fraunces">
            <h1 class="text-4xl font-bold text-[#1F305E]">Steclib.</h1>
            <ul class="flex gap-10 items-center">
                <li>
                    <a href="{{ route('page.home') }}"
                        class="{{ request()->routeIs('page.home') ? 'text-ourblue border-b-2 font-bold border-b-ourblue' : 'text-[#635147] hover:text-ourblue' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('books.daftar') }}"
                        class="{{ request()->routeIs('books.daftar') ? 'text-ourblue border-b-2 font-bold border-b-ourblue' : 'text-[#635147] hover:text-ourblue' }}">
                        Daftar Buku
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.index') }}"
                        class="{{ request()->routeIs('peminjaman.index') ? 'text-ourblue border-b-2 font-bold border-b-ourblue' : 'text-[#635147] hover:text-ourblue' }}">
                        Daftar Pinjaman
                    </a>
                </li>
                <li>
                    <a href="{{ route('wishlists.index') }}"
                        class="{{ request()->routeIs('wishlists.index') ? 'text-ourblue border-b-2 font-bold border-b-ourblue' : 'text-[#635147] hover:text-ourblue' }}">
                        Wishlist
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex items-center gap-4">
            @if(Auth::check())
                <a href="{{ route('user.profile') }}"><span class="text-[#1F305E] font-bold">{{ Auth::user()->username }}</span></a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">
                    <button class="text-blue-600 hover:underline">Login</button>
                </a>
            @endif
        </div>
    </div>
</nav>