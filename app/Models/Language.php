<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'country_id',
        'name',
        'name_native',
        'code1',
        'code2'
    ];
}
