<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WishlistController extends Controller
{
    /**
     * Display a listing of all wishlist items or filter by user if authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // If the user is logged in and no specific filter is requested,
        // default to showing their wishlist
        if (auth()->check() && !$request->has('username')) {
            $wishlists = Wishlist::with('buku')
                ->where('username', auth()->user()->username)
                ->get();

            return view('wishlists.index', [
                'wishlists' => $wishlists,
                'user' => auth()->user()
            ]);
        }

        // If a specific username is requested and the user has permission to view it
        // (either it's their own or they're an admin)
        else if (
            $request->has('username') &&
            (auth()->check() &&
                (auth()->user()->username == $request->username || auth()->user()->isAdmin()))
        ) {

            $user = User::where('username', $request->username)->firstOrFail();
            $wishlists = Wishlist::with('buku')
                ->where('username', $request->username)
                ->get();

            return view('wishlists.index', [
                'wishlists' => $wishlists,
                'user' => $user
            ]);
        }

        // For admin view of all wishlists (if the user is an admin)
        else if (auth()->check() && auth()->user()->isAdmin()) {
            $wishlists = Wishlist::with(['user', 'buku'])->get();

            return view('wishlists.admin', [
                'wishlists' => $wishlists
            ]);
        }

        // If not logged in or not authorized, redirect to login
        return redirect()->route('login')
            ->with('error', 'You must be logged in to view wishlists.');
    }

    /**
     * Show the form for adding a new book to wishlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to add books to your wishlist.');
        }

        // Get all books that are not already in the user's wishlist
        $existingWishlistIsbns = Wishlist::where('username', auth()->user()->username)
            ->pluck('isbn')
            ->toArray();

        $availableBooks = Buku::whereNotIn('isbn', $existingWishlistIsbns)->get();

        return view('wishlists.create', [
            'books' => $availableBooks
        ]);
    }

    /**
     * Add a book to the user's wishlist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to add books to your wishlist.');
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'isbn' => [
                'required',
                'string',
                'max:20',
                'exists:bukus,isbn',
                // Ensure this username-isbn combination doesn't already exist
                Rule::unique('wishlists')->where(function ($query) use ($request) {
                    return $query->where('username', auth()->user()->username)
                        ->where('isbn', $request->isbn);
                })
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('wishlists.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create new wishlist entry
        $wishlist = new Wishlist();
        $wishlist->username = auth()->user()->username;
        $wishlist->isbn = $request->isbn;
        $wishlist->save();

        return redirect()->route('wishlists.index')
            ->with('success', 'Book added to your wishlist successfully.');
    }

    /**
     * Quick add a book to wishlist directly from book details page.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function quickAdd($isbn)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to add books to your wishlist.');
        }

        // Check if book exists
        $book = Buku::where('isbn', $isbn)->firstOrFail();

        // Check if already in wishlist
        $existing = Wishlist::where('username', auth()->user()->username)
            ->where('isbn', $isbn)
            ->first();

        if ($existing) {
            return back()->with('info', 'This book is already in your wishlist.');
        }

        // Add to wishlist
        $wishlist = new Wishlist();
        $wishlist->username = auth()->user()->username;
        $wishlist->isbn = $isbn;
        $wishlist->save();

        return back()->with('success', 'Book added to your wishlist.');
    }

    /**
     * Remove a book from the wishlist.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function destroy($isbn)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to remove books from your wishlist.');
        }

        try {
            $username = auth()->user()->username;

            // Direct DB delete to ensure we're using the composite key properly
            $deleted = Wishlist::where('isbn', $isbn)
                ->where('username', $username)
                ->delete();

            if ($deleted) {
                return redirect()->route('wishlists.index')
                    ->with('success', 'Book removed from your wishlist.');
            } else {
                return redirect()->route('wishlists.index')
                    ->with('error', 'Could not find the book in your wishlist.');
            }
        } catch (\Exception $e) {
            \Log::error('Error removing book from wishlist', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('wishlists.index')
                ->with('error', 'An error occurred while removing the book from your wishlist.');
        }
    }
    /**
     * Display users who have a specific book in their wishlist (admin only).
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function bookWishlists($isbn)
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this page.');
        }

        // Get the book details
        $book = Buku::where('isbn', $isbn)->firstOrFail();

        // Get all users who have this book in their wishlist
        $wishlists = Wishlist::with('user')
            ->where('isbn', $isbn)
            ->get();

        return view('wishlists.book', [
            'book' => $book,
            'wishlists' => $wishlists
        ]);
    }

    /**
     * Check if a book is in the current user's wishlist (for AJAX requests).
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function checkStatus($isbn)
    {
        if (!auth()->check()) {
            return response()->json([
                'in_wishlist' => false
            ]);
        }

        $exists = Wishlist::where('username', auth()->user()->username)
            ->where('isbn', $isbn)
            ->exists();

        return response()->json([
            'in_wishlist' => $exists
        ]);
    }
}