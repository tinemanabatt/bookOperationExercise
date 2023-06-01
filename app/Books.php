<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name_of_book',
        'image_of_book',
        'is_borrowed'
    ];
}
