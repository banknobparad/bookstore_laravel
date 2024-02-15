<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    protected $guarded =[];

    use HasFactory;


function ctgybook()
{
    return $this->hasOne( 'App\Models\bookcategory', 'id', 'ctgy_book' );
}
}
