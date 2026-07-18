<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'author',
        'text',
        'rating',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
