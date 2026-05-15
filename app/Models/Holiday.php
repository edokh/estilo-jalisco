<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['name', 'date', 'note'];

    protected $casts = [
        'date' => 'date',
    ];

    public static function isHolidayToday()
    {
        return static::where('date', today())->exists();
    }
}
