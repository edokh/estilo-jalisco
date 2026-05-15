<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'image', 'order', 'active'];

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }
}
