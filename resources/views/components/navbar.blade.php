<nav class="">
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout ({{ auth()->user()->username }})</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Register</a>
    @endauth
</nav>
<nav class="">
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout ({{ auth()->user()->username }})</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Register</a>
    @endauth
</nav>