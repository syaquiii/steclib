<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the borrowings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->get();
        return view('peminjamans.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new borrowing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $books = Buku::all();
        return view('peminjamans.create', compact('users', 'books'));
    }

    /**
     * Store a newly created borrowing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'isbn' => 'required|exists:bukus,isbn',
            'tanggal_pinjam' => 'required|date',
            'tanggal_wajib_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the user already has an active borrowing for this book
        $existingBorrowing = Peminjaman::where('username', $request->username)
            ->where('isbn', $request->isbn)
            ->whereNull('tanggal_kembali')
            ->first();

        if ($existingBorrowing) {
            return redirect()->back()
                ->with('error', 'The user already has an active borrowing for this book.')
                ->withInput();
        }

        // Generate a unique ID for the borrowing
        $borrowingId = 'PJM-' . date('Ymd') . '-' . Str::random(5);

        Peminjaman::create([
            'id' => $borrowingId,
            'username' => $request->username,
            'isbn' => $request->isbn,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_wajib_kembali' => $request->tanggal_wajib_kembali,
        ]);

        return redirect()->route('peminjamans.index')
            ->with('success', 'Borrowing record created successfully.');
    }

    /**
     * Display the specified borrowing.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('peminjamans.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified borrowing.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::all();
        $books = Buku::all();
        return view('peminjamans.edit', compact('peminjaman', 'users', 'books'));
    }

    /**
     * Update the specified borrowing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'isbn' => 'required|exists:bukus,isbn',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'tanggal_wajib_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $peminjaman->update($request->all());

        return redirect()->route('peminjamans.index')
            ->with('success', 'Borrowing record updated successfully.');
    }

    /**
     * Remove the specified borrowing from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjamans.index')
            ->with('success', 'Borrowing record deleted successfully.');
    }

    /**
     * Return a book.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function returnBook($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // If book is already returned
        if ($peminjaman->tanggal_kembali) {
            return redirect()->back()
                ->with('error', 'This book has already been returned.');
        }

        $peminjaman->update([
            'tanggal_kembali' => Carbon::now()->toDateString()
        ]);

        return redirect()->route('peminjamans.index')
            ->with('success', 'Book returned successfully.');
    }

    /**
     * Show overdue borrowings.
     *
     * @return \Illuminate\Http\Response
     */
    public function overdue()
    {
        $today = Carbon::now()->toDateString();

        $overduePeminjamans = Peminjaman::with(['user', 'buku'])
            ->whereNull('tanggal_kembali')
            ->where('tanggal_wajib_kembali', '<', $today)
            ->get();

        return view('peminjamans.overdue', compact('overduePeminjamans'));
    }
}