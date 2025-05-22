<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::all();
        $books = Buku::all();
        return view('admin.peminjaman.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'isbn' => 'required|exists:bukus,isbn',
            'tanggal_pinjam' => 'required|date',
            'tanggal_wajib_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek pinjaman aktif
        $existing = Peminjaman::where('username', $request->username)
            ->where('isbn', $request->isbn)
            ->whereNull('tanggal_kembali')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'User already has an active borrowing for this book.')->withInput();
        }

        // Custom ID (pastikan kolom `id` di DB adalah VARCHAR)
        $borrowingId = 'PJM-' . date('Ymd') . '-' . Str::upper(Str::random(5));

        Peminjaman::create([
            'id' => $borrowingId,
            'username' => $request->username,
            'isbn' => $request->isbn,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_wajib_kembali' => $request->tanggal_wajib_kembali,
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Borrowing record created successfully.');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('peminjamans.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::all();
        $books = Buku::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'books'));
    }

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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $peminjaman->update($request->only([
            'username',
            'isbn',
            'tanggal_pinjam',
            'tanggal_kembali',
            'tanggal_wajib_kembali'
        ]));

        return redirect()->route('admin.peminjaman.index')->with('success', 'Borrowing record updated successfully.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Borrowing record deleted successfully.');
    }

    public function returnBook($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->tanggal_kembali) {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        $peminjaman->update([
            'tanggal_kembali' => Carbon::now()->toDateString()
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Book returned successfully.');
    }

    public function overdue()
    {
        $today = Carbon::now()->toDateString();

        $overdues = Peminjaman::with(['user', 'buku'])
            ->whereNull('tanggal_kembali')
            ->where('tanggal_wajib_kembali', '<', $today)
            ->get();

        return view('peminjamans.overdue', compact('overdues'));
    }
}
