<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;
    protected $table = 'borrowed_books';

    protected $fillable = [
        'id',
        'library_id',
        'user_id',
        'delivery_date',
        'return_date'
    ];

    /**
     * The roles that belong to the user.
     */
    public function borrowedBookUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'borrowed_books', 'id');
    }
}
