@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Register</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required>
            </div>

            <div>
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <div>
                <label>Role</label>
                <select name="is_admin" required>
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>

            <button type="submit">Register</button>
        </form>

        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </div>
@endsection