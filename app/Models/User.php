<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'username';

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
        'username',
        'nama_lengkap',
        'email',
        'password',
        'tanggal_lahir',
        'lokasi',
        'is_admin',
        'foto_profil',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_admin' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Get the peminjamans associated with the user.
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'username', 'username');
    }

    /**
     * Get the wishlists associated with the user.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'username', 'username');
    }

    /**
     * Get the reviews associated with the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'username', 'username');
    }

    /**
     * Get the books in user's wishlist.
     */
    public function wishlistBooks()
    {
        return $this->belongsToMany(Buku::class, 'wishlists', 'username', 'isbn');
    }

    /**
     * Get the books reviewed by the user.
     */
    public function reviewedBooks()
    {
        return $this->belongsToMany(Buku::class, 'reviews', 'username', 'isbn')
            ->withPivot('review');
    }
}