<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Review;
class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil 4 buku terbaru
        $bukuBaru = Buku::with('penerbit')
            ->orderByDesc('tahun_terbit')
            ->take(4)
            ->get();
        $bestBook = Buku::with('penerbit')
            ->withCount('peminjamans') // Hitung jumlah peminjaman
            ->orderByDesc('peminjamans_count') // Urutkan dari yang paling banyak
            ->first();


        // Ambil 4 buku trending berdasarkan jumlah peminjaman terbanyak
        $trending = Buku::with('penerbit')
            ->withCount('peminjamans') // hitung jumlah peminjaman
            ->orderByDesc('peminjamans_count') // urutkan dari yang paling banyak
            ->take(4)
            ->get();
        $reviews = Review::with(['user', 'buku'])->latest()->take(20)->get();

        return view('page.home', compact('bukuBaru', 'trending', 'bestBook', 'reviews'));
    }
}
