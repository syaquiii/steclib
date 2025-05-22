<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Create a new peminjaman (borrowing) record
     * 
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function store($isbn)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $username = Auth::user()->username;
        $buku = Buku::where('isbn', $isbn)->first();

        // Pastikan buku ada
        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        // Cek apakah user sudah meminjam buku ini dan belum mengembalikannya
        $existingLoan = Peminjaman::where('username', $username)
            ->where('isbn', $isbn)
            ->whereNull('tanggal_kembali')
            ->exists();

        if ($existingLoan) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        // Simpan data peminjaman
        Peminjaman::create([
            'id' => Str::uuid()->toString(),
            'username' => $username,
            'isbn' => $isbn,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_wajib_kembali' => Carbon::now()->addDays(14),
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dipinjam.');
    }

    /**
     * Display a listing of user's borrowed books
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = Auth::user()->username;

        $activePeminjamans = Peminjaman::where('username', $username)
            ->whereNull('tanggal_kembali')
            ->with('buku')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $historyPeminjamans = Peminjaman::where('username', $username)
            ->whereNotNull('tanggal_kembali')
            ->with('buku')
            ->orderBy('tanggal_kembali', 'desc')
            ->paginate(10);

        return view('peminjaman.index', compact('activePeminjamans', 'historyPeminjamans'));
    }

    /**
     * Show the details of a specific peminjaman
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        // Make sure the user can only see their own peminjaman
        if ($peminjaman->username !== Auth::user()->username) {
            abort(403, 'Unauthorized action.');
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Request to return a borrowed book
     * 
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function returnRequest($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Make sure the user can only return their own peminjaman
        if ($peminjaman->username !== Auth::user()->username) {
            abort(403, 'Unauthorized action.');
        }

        // Check if book is already returned
        if ($peminjaman->tanggal_kembali) {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
        }

        // Update return date
        $peminjaman->tanggal_kembali = Carbon::now();
        $peminjaman->save();

        // Increase book stock if applicable
        $buku = $peminjaman->buku;
        if ($buku && isset($buku->stok)) {
            $buku->stok += 1;
            $buku->save();
        }

        // Check if book is returned late
        if ($peminjaman->isOverdue()) {
            $daysLate = $peminjaman->daysOverdue();
            return redirect()->route('peminjaman.index')->with('warning', "Buku dikembalikan terlambat $daysLate hari. Mungkin ada denda.");
        }

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    /**
     * Calculate penalties for overdue books
     *
     * @return \Illuminate\Http\Response
     */
    public function penalties()
    {
        $username = Auth::user()->username;

        $overduePeminjamans = Peminjaman::where('username', $username)
            ->where(function ($query) {
                $query->whereNull('tanggal_kembali')
                    ->where('tanggal_wajib_kembali', '<', Carbon::now());
            })
            ->orWhere(function ($query) use ($username) {
                $query->where('username', $username)
                    ->whereNotNull('tanggal_kembali')
                    ->whereRaw('tanggal_kembali > tanggal_wajib_kembali');
            })
            ->with('buku')
            ->get();

        // Calculate total penalty (assuming Rp 1000 per day)
        $totalPenalty = 0;
        foreach ($overduePeminjamans as $peminjaman) {
            $totalPenalty += $peminjaman->daysOverdue() * 1000; // Rp 1000 per day
        }

        return view('peminjaman.penalties', compact('overduePeminjamans', 'totalPenalty'));
    }
}