@extends('layouts.app')
<x-navbar />

@section('content')
<div class="grid grid-cols-2 min-h-screen pt-40">
<div>
    <div class="bg-[#635147] mr-0 w-1/2">
    <h1>Profil</h1>
    <div class="flex justify-center items-center">
        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="rounded-full w-32 h-32 mt-5">
    </div>
    <p>{{ $user->nama_lengkap }}</p>
    <p>@ {{ $user->username }}</p>
    <p>{{ $user->bio }}</p>
    </div>
</div>

<div class="container w-4/5 mx-auto mt-5 text-[#1F305E]">
    <h2 class="text-2xl font-bold mb-4">Edit Profil</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-x-4 gap-y-8">
        <div>
            <label for="name" class="block font-semibold">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                   class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('name') border-red-500 @enderror">
            @error('nama_lengkap')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="username" class="block font-semibold">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('username') border-red-500 @enderror" disabled>
            @error('username')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('email') border-red-500 @enderror">
            @error('email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="tanggal_lahir" class="block font-semibold">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                   class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('role') border-red-500 @enderror">
            @error('tanggal_lahir')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="is_admin" class="block font-semibold">Role</label>
            <select name="is_admin" class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('role') border-red-500 @enderror">
                <option value="1" {{ old('is_admin', $user->is_admin) == '1' ? 'selected' : '' }}>Admin</option>
                <option value="0" {{ old('is_admin', $user->is_admin) == '0' ? 'selected' : '' }}>Anggota</option>
            </select>
            @error('role')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="lokasi" class="block font-semibold">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi', $user->lokasi) }}"
                   class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('lokasi') border-red-500 @enderror">
            @error('no_telp')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password" class="block font-semibold">Password Baru (opsional)</label>
            <input type="password" name="password"
                   class="bg-[#F6F4F1] p-2 rounded-lg w-full @error('password') border-red-500 @enderror">
            @error('password')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="bg-[#F6F4F1] w-full p-2 rounded-lg">
        </div>
        </div>

        <div class="mb-4">
            <label for="bio" class="block font-semibold">Bio</label>
            <textarea name="bio" rows="4"
                      class="bg-[#F6F4F1] w-full p-2 rounded-lg @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-[#1F305E] text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>
        <a href="{{ route('page.home') }}">Kembali</a>
    </form>
</div>
</div>
@endsection
