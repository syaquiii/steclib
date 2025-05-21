<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bukus = Buku::with('penerbit')->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $publishers = Penerbit::all();
        return view('admin.buku.create', compact('publishers'));
    }

    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|string|max:20|unique:bukus',
            'judul' => 'required|string|max:45',
            'pengarang' => 'required|string|max:45',
            'id_penerbit' => 'required|exists:penerbits,id',
            'cover' => 'required|image|max:2048', // max 2MB
            'sinopsis' => 'required|string',
            'tagline' => 'required|string|max:200',
            'konten' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bookData = $request->except('cover');

        // Handle file upload for book cover
        if ($request->hasFile('cover')) {
            try {
                $file = $request->file('cover');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Store the file in the correct location
                // Note: We need to manually create the directory structure if it doesn't exist
                $path = $request->file('cover')->store('images/url', 'public');

                // Log storage path
                Log::info('File uploaded to: ' . $path);

                // Store the path in the database without the 'public/' prefix
                $bookData['cover'] = $path;

            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
                return redirect()->back()
                    ->withErrors(['cover' => 'Error uploading file: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        Buku::create($bookData);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Book created successfully.');
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
        $reviews = $book->reviews()->with('user')->get();
        return view('books.show', compact('book', 'reviews'));
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function edit($isbn)
    {
        $buku = Buku::findOrFail($isbn);
        $penerbits = Penerbit::all();
        return view('admin.buku.edit', compact('buku', 'penerbits'));
    }

    /**
     * Update the specified book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $isbn)
    {
        $buku = Buku::findOrFail($isbn);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:45',
            'id_penerbit' => 'required|exists:penerbits,id',
            'cover' => 'nullable|image|max:2048', // max 2MB
            'sinopsis' => 'required|string',
            'tagline' => 'required|string|max:200',
            'konten' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bookData = $request->except(['cover', '_token', '_method']);

        // Handle file upload if a new cover is provided
        if ($request->hasFile('cover')) {
            try {
                // Delete old cover if exists
                if ($buku->cover) {
                    Storage::disk('public')->delete($buku->cover);
                }

                // Store the file in the correct location
                $path = $request->file('cover')->store('images/url', 'public');

                // Log storage path
                Log::info('File updated to: ' . $path);

                // Store the path in the database
                $bookData['cover'] = $path;

            } catch (\Exception $e) {
                Log::error('File update error: ' . $e->getMessage());
                return redirect()->back()
                    ->withErrors(['cover' => 'Error updating file: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        $buku->update($bookData);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function destroy($isbn)
    {
        $book = Buku::findOrFail($isbn);

        // Check if the book has associated peminjamans
        if ($book->peminjamans()->count() > 0) {
            return redirect()->route('admin.buku.index')
                ->with('error', 'Cannot delete book. It has associated borrowing records.');
        }

        // Delete cover image if exists
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        // Delete associated wishlists and reviews
        $book->wishlistUsers()->detach();
        $book->reviewers()->detach();

        $book->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Book deleted successfully.');
    }

    /**
     * Add a review to the book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function addReview(Request $request, $isbn)
    {
        $book = Buku::findOrFail($isbn);

        $validator = Validator::make($request->all(), [
            'review' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the user has already reviewed this book
        $existingReview = $book->reviews()->where('username', auth()->user()->username)->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'review' => $request->review
            ]);
            $message = 'Review updated successfully.';
        } else {
            // Create new review
            $book->reviews()->create([
                'username' => auth()->user()->username,
                'review' => $request->review
            ]);
            $message = 'Review added successfully.';
        }

        return redirect()->route('books.show', $isbn)
            ->with('success', $message);
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
            // Remove from wishlist
            $user->wishlistBooks()->detach($isbn);
            $message = 'Book removed from wishlist.';
        } else {
            // Add to wishlist
            $user->wishlistBooks()->attach($isbn);
            $message = 'Book added to wishlist.';
        }

        return redirect()->back()->with('success', $message);
    }
}