@extends('layouts.app')

@section('content')
    <section class="container  h-screen">
        <h2>Login</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label>email</label>
                <input type="text" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </section>
@endsection