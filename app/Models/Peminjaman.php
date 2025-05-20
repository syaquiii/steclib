<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
        'id',
        'username',
        'isbn',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_wajib_kembali',
    ];

    protected $table = 'peminjamans';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_wajib_kembali' => 'date',
    ];

    /**
     * Get the user that owns the peminjaman.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    /**
     * Get the book that is being borrowed.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'isbn', 'isbn');
    }

    /**
     * Check if the book is overdue.
     *
     * @return bool
     */
    public function isOverdue()
    {
        if ($this->tanggal_kembali) {
            return $this->tanggal_kembali->isAfter($this->tanggal_wajib_kembali);
        }

        return now()->isAfter($this->tanggal_wajib_kembali);
    }

    /**
     * Calculate how many days overdue the book is.
     *
     * @return int
     */
    public function daysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        if ($this->tanggal_kembali) {
            return $this->tanggal_kembali->diffInDays($this->tanggal_wajib_kembali);
        }

        return now()->diffInDays($this->tanggal_wajib_kembali);
    }
}