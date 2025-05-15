<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all reviews with related user and book information
        $reviews = Review::with(['user', 'buku'])->get();

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get users and books for dropdown options
        $users = User::all();
        $books = Buku::all();

        return view('reviews.create', compact('users', 'books'));
    }

    /**
     * Store a newly created review in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:20',
                'exists:users,username'
            ],
            'isbn' => [
                'required',
                'string',
                'max:20',
                'exists:bukus,isbn',
                // Ensure this username-isbn combination doesn't already exist
                Rule::unique('reviews')->where(function ($query) use ($request) {
                    return $query->where('username', $request->username)
                        ->where('isbn', $request->isbn);
                })
            ],
            'review' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('reviews.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create new review
        $review = new Review();
        $review->username = $request->username;
        $review->isbn = $request->isbn;
        $review->review = $request->review;
        $review->save();

        return redirect()->route('reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified review.
     *
     * @param  string  $username
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function show($username, $isbn)
    {
        // Find the review with composite key
        $review = Review::where('username', $username)
            ->where('isbn', $isbn)
            ->firstOrFail();

        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     *
     * @param  string  $username
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function edit($username, $isbn)
    {
        // Find the review with composite key
        $review = Review::where('username', $username)
            ->where('isbn', $isbn)
            ->firstOrFail();

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username, $isbn)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'review' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('reviews.edit', ['username' => $username, 'isbn' => $isbn])
                ->withErrors($validator)
                ->withInput();
        }

        // Find and update the review
        $review = Review::where('username', $username)
            ->where('isbn', $isbn)
            ->firstOrFail();

        $review->review = $request->review;
        $review->save();

        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review from the database.
     *
     * @param  string  $username
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function destroy($username, $isbn)
    {
        // Find and delete the review
        $review = Review::where('username', $username)
            ->where('isbn', $isbn)
            ->firstOrFail();

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Display reviews by a specific user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function userReviews($username)
    {
        // Get all reviews by a specific user
        $reviews = Review::with('buku')
            ->where('username', $username)
            ->get();
        $user = User::where('username', $username)->firstOrFail();

        return view('reviews.user', compact('reviews', 'user'));
    }

    /**
     * Display reviews for a specific book.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function bookReviews($isbn)
    {
        // Get all reviews for a specific book
        $reviews = Review::with('user')
            ->where('isbn', $isbn)
            ->get();
        $book = Buku::where('isbn', $isbn)->firstOrFail();

        return view('reviews.book', compact('reviews', 'book'));
    }
}