<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'book_archive',
        'name',
        'author_id',
        'editor_id',
        'publisher_id',
        'gender_id',
        'language_id',
        'date_of_publication',
        'number_page',
        'image'
    ];
}
