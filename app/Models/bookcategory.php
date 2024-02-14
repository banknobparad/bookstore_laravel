<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookcategory extends Model
{
    protected $fillable = [
        'num_book',
        'name_book',
        'book',
    ];
    use HasFactory;
}
