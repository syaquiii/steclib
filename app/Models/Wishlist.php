<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wishlists';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'isbn';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'isbn',
    ];

    /**
     * Get the user that owns the wishlist item.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    /**
     * Get the book that is in the wishlist.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'isbn', 'isbn');
    }

    /**
     * Override the getRouteKeyName method to ensure proper route model binding
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'isbn';
    }
}