<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = [
        'user_id',
        'name_of_book',
        'image_of_book',
        'is_borrowed'
    ];
}
