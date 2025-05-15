<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviews';

    /**
     * The primary key is composite, so we need to disable the default ID column.
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
        'isbn',
        'review',
    ];

    /**
     * Set the keys for the model.
     *
     * @return array
     */
    public function getKeyName()
    {
        return ['username', 'isbn'];
    }

    /**
     * Get the user that wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    /**
     * Get the book that is being reviewed.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'isbn', 'isbn');
    }
}