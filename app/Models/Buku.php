<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'isbn';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'isbn',
        'judul',
        'pengarang',
        'id_penerbit',
        'cover',
        'sinopsis',
        'tagline',
        'konten',
        'tahun_terbit',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
    ];

    /**
     * Get the publisher that owns the book.
     */
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit', 'id');
    }

    /**
     * Get the peminjamans for the book.
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'isbn', 'isbn');
    }

    /**
     * Get the users who have this book in their wishlists.
     */
    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'isbn', 'username');
    }

    /**
     * Get the users who have reviewed this book.
     */
    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviews', 'isbn', 'username')
            ->withPivot('review');
    }

    /**
     * Get the reviews for the book.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'isbn', 'isbn');
    }
}