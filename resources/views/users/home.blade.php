@extends('layouts.app')

@section('content')
    <div class="container bg-red-200">
        <h1>Selamat datang, {{ Auth::user()->nama_lengkap }}</h1>
        <p>Ini adalah halaman user.</p>
    </div>
@endsection