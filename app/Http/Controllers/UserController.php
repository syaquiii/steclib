<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:20|unique:users',
            'nama_lengkap' => 'required|string|max:45',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tanggal_lahir' => 'nullable|date',
            'lokasi' => 'nullable|string|max:100',
            'is_admin' => 'required|boolean',
            'foto_profil' => 'nullable|image|max:2048', // max 2MB
            'bio' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->except('foto_profil', 'password_confirmation');
        $userData['password'] = Hash::make($request->password);

        // Handle file upload if a profile photo is provided
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_photos', $filename);
            $userData['foto_profil'] = 'profile_photos/' . $filename;
        }

        User::create($userData);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::findOrFail($username);
        return view('users.show', compact('user'));
    }
    public function dashboard()
    {
        // Add your dashboard logic here
        return view('users.dashboard');
    }
    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        $user = User::findOrFail($username);

        if(Auth::user()->is_admin) {
            return view('admin.user.edit', compact('user'));
        }

        if (Auth::user()->username !== $username) {
            return redirect()->route('users.index')->with('error', 'Unauthorized access.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username)
    {
        $user = User::findOrFail($username);

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:45',
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                Rule::unique('users')->ignore($username, 'username'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'tanggal_lahir' => 'nullable|date',
            'lokasi' => 'nullable|string|max:100',
            'is_admin' => 'required|boolean',
            'foto_profil' => 'nullable|image|max:2048', // max 2MB
            'bio' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->except(['foto_profil', 'password', 'password_confirmation', '_token', '_method']);

        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle file upload if a new profile photo is provided
        if ($request->hasFile('foto_profil')) {
            // Delete old profile photo if exists
            if ($user->foto_profil) {
                Storage::delete('public/' . $user->foto_profil);
            }

            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_photos', $filename);
            $userData['foto_profil'] = 'profile_photos/' . $filename;
        }

        $user->update($userData);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        $user = User::findOrFail($username);

        // Delete profile photo if exists
        if ($user->foto_profil) {
            Storage::delete('public/' . $user->foto_profil);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display the user's wishlist.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function wishlist($username)
    {
        $user = User::findOrFail($username);
        $wishlistBooks = $user->wishlistBooks;

        return view('users.wishlist', compact('user', 'wishlistBooks'));
    }

    /**
     * Display the user's borrowed books.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function borrowedBooks($username)
    {
        $user = User::findOrFail($username);
        $peminjamans = $user->peminjamans()->with('buku')->get();

        return view('users.borrowed', compact('user', 'peminjamans'));
    }

    /**
     * Display the user's reviews.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function reviews($username)
    {
        $user = User::findOrFail($username);
        $reviews = $user->reviews()->with('buku')->get();

        return view('users.reviews', compact('user', 'reviews'));
    }
}