<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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

        // Debug: Pastikan user memiliki username (primary key)
        if (!$user || !$user->username) {
            return redirect()->route('login')->with('error', 'User tidak valid. Silakan login kembali.');
        }

        // Validasi menggunakan Rule::unique dengan username sebagai key
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->username, 'username')
            ],
            'tanggal_lahir' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string|max:500',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update data user menggunakan mass assignment
        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'lokasi' => $validated['lokasi'],
            'bio' => $validated['bio']
        ];

        // Update foto profil jika ada file yang diupload
        if ($request->hasFile('foto_profil')) {
            try {
                // Hapus foto lama jika ada
                if ($user->foto_profil) {
                    Storage::disk('public')->delete($user->foto_profil);
                }

                // Handle file upload for profile image - sama seperti BukuController
                $file = $request->file('foto_profil');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Store the file in the same location as book covers
                $path = $request->file('foto_profil')->store('images/url', 'public');

                // Log storage path
                Log::info('Profile image uploaded to: ' . $path);

                // Store the path in the database without the 'public/' prefix
                $updateData['foto_profil'] = $path;

            } catch (\Exception $e) {
                Log::error('Profile image upload error: ' . $e->getMessage());
                return redirect()->back()
                    ->withErrors(['foto_profil' => 'Error uploading profile image: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Update user dengan data yang sudah disiapkan
        $user->update($updateData);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}