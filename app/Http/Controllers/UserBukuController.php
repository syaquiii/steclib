<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WishlistController;
use App\Models\Buku;
use App\Models\Wishlist;
use App\Models\Peminjaman;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBukuController extends Controller
{
    /**
     * Display a listing of the books for users.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $books = Buku::with('penerbit')->paginate(12);
        $trending = Buku::with('penerbit')
            ->withCount('peminjamans') // hitung jumlah peminjaman
            ->orderByDesc('peminjamans_count') // urutkan dari yang paling banyak
            ->take(6)
            ->get();
        $latestBooks = Buku::with('penerbit')
            ->orderByDesc('created_at') // urut dari yang terbaru
            ->paginate(12);
        $latestbooks = Buku::with('penerbit')
            ->orderByDesc('tahun_terbit')
            ->take(6)
            ->get();
        return view('books.index', compact('books', 'trending', 'latestbooks'));
    }

    /**
     * Display the specified book.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function show($isbn)
    {
        $book = Buku::with('penerbit')->findOrFail($isbn);
        $relatedBooks = Buku::where('id_penerbit', $book->id_penerbit)
            ->where('isbn', '!=', $isbn)
            ->take(4)
            ->get();
        $bookInWishlist = Wishlist::where('username', auth()->user()->username)
            ->where('isbn', $isbn)
            ->exists();
        $reviews = $book->reviews()->with('user')->get();
        $existingLoan = Auth::check() ? Peminjaman::where('username', Auth::user()->username)
            ->where('isbn', $isbn)
            ->whereNull('tanggal_kembali')
            ->exists() : false;
        $latestbooks = Buku::with('penerbit')
            ->orderByDesc('tahun_terbit')
            ->take(6) // ambil 4 terbaru (atau sesuaikan)
            ->get();

        $reviewsOnIsbn = $reviews = Review::with('user')->where('isbn', $isbn)->get();
        return view('books.show', compact(
            'book',
            'reviews',
            'reviewsOnIsbn',
            'relatedBooks',
            'existingLoan',
            'latestbooks',
            'bookInWishlist'
        ));
    }

    /**
     * Search books.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $books = Buku::where('judul', 'like', "%$query%")
            ->orWhere('pengarang', 'like', "%$query%")
            ->paginate(12);

        return view('user.books.search', compact('books', 'query'));
    }

    /**
     * Display books by category.
     *
     * @param  string  $category
     * @return \Illuminate\Http\Response
     */
    public function byCategory($category)
    {
        // Implement your category logic here
        $books = Buku::where('category', $category)->paginate(12);
        return view('user.books.category', compact('books', 'category'));
    }

    /**
     * Toggle wishlist status for the book.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function toggleWishlist($isbn)
    {
        $book = Buku::findOrFail($isbn);
        $user = auth()->user();

        if ($user->wishlistBooks()->where('isbn', $isbn)->exists()) {
            $user->wishlistBooks()->detach($isbn);
            $message = 'Book removed from wishlist.';
        } else {
            $user->wishlistBooks()->attach($isbn);
            $message = 'Book added to wishlist.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Display user's wishlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function wishlist()
    {
        $books = auth()->user()->wishlistBooks()->paginate(12);
        return view('user.books.wishlist', compact('books'));
    }

    /**
     * Store a new review for the book.
     *
     * @param  Request  $request
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function storeReview(Request $request, $isbn)
    {
        $request->validate([
            'review' => 'required|string|max:255',
        ]);

        $book = Buku::findOrFail($isbn);
        $user = auth()->user();

        $review = Review::updateOrCreate(
            ['username' => $user->username, 'isbn' => $isbn],
            ['review' => $request->review]
        );

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    /**
     * Get reviews for a book.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function getReviews($isbn)
    {
        $reviews = Review::with('user')->where('isbn', $isbn)->get();
        return response()->json($reviews);
    }
}