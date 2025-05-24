<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PenerbitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\PeminjamanController as UserPeminjamanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserBukuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserEditController;

// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('penerbit', PenerbitController::class);

    Route::get('/admin/user/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');

    Route::resource('user', UserController::class);

    Route::resource('buku', BukuController::class);
    Route::get('/admin/buku/{buku}/edit', [BukuController::class, 'edit'])->name('admin.buku.edit');
    Route::put('/admin/buku/{buku}', [BukuController::class, 'update'])->name('admin.buku.update');

    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/admin/peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('admin.peminjaman.edit');
    Route::put('/admin/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('admin.peminjaman.update');
});
// Landing Page (tetap bisa diakses user umum)
Route::get('/', [LandingPageController::class, 'index'])->name('page.home');

// Route daftar buku untuk user (bukan admin)
Route::get('/books/daftar', [UserBukuController::class, 'index'])->name('books.daftar');

// Detail buku user
Route::get('/books/{isbn}', [UserBukuController::class, 'show'])->name('books.show');
Route::middleware(['auth'])->group(function () {
    Route::post('/books/{isbn}/wishlist', [BukuController::class, 'toggleWishlist'])->name('books.wishlist');
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/books/{isbn}/reviews', [ReviewController::class, 'bookReviews'])->name('reviews.book');
    Route::post('/peminjaman/{isbn}', [UserPeminjamanController::class, 'store'])->name('peminjaman.store');
    // Index route
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlists.index');

    // Quick add route
    Route::post('/wishlist/{isbn}/add', [WishlistController::class, 'quickAdd'])->name('wishlist.quickAdd');

    // Destroy route - this is key for the delete functionality
    Route::delete('/wishlists/{isbn}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');

    // Other resource routes excluding the ones already defined
    Route::resource('wishlists', WishlistController::class)->except(['index', 'destroy']);

    // Additional wishlist routes
    Route::get('/wishlists/book/{isbn}', [WishlistController::class, 'bookWishlists'])->name('wishlists.book');
    Route::get('/wishlists/check/{isbn}', [WishlistController::class, 'checkStatus'])->name('wishlists.check');


    Route::get('/my-books', [UserPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/my-books/{id}/return', [UserPeminjamanController::class, 'returnRequest'])->name('peminjaman.return');
    Route::get('/my-penalties', [PeminjamanController::class, 'penalties'])->name('peminjaman.penalties');


});

Route::get('/profile', [UserEditController::class, 'edit'])->name('user.profile');
Route::post('/profile', [UserEditController::class, 'update'])->name('profile.update');