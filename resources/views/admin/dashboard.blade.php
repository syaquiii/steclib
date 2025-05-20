@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Selamat datang, {{ Auth::user()->nama_lengkap }}</h1>
        <p>Ini adalah halaman Admin.</p>
    </div>
@endsection