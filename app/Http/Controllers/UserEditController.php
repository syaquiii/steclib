<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserEditController extends Controller
{
    /**
     * Show the form for editing the authenticated user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->username . ',username',
            'tanggal_lahir' => 'nullable|date',
            'is_admin' => 'required|boolean',
            'lokasi' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string|max:255',
        ]);

        // Update data user
        $user->nama_lengkap = $validated['nama_lengkap'];
        $user->email = $validated['email'];
        $user->tanggal_lahir = $validated['tanggal_lahir'];
        $user->is_admin = $validated['is_admin'];
        $user->lokasi = $validated['lokasi'];
        $user->bio = $validated['bio'];
        // Update foto profil jika diisi
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $user->foto_profil = 'uploads/' . $filename;
        }

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}