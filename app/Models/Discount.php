<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['food_item_id', 'name', 'description', 'type', 'value', 'start_date', 'end_date', 'active'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean',
        'value' => 'decimal:2',
    ];

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }
}
