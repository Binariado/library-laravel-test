<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'library_id',
        'user_id',
        'delivery_date',
        'return_date'
    ];
}
