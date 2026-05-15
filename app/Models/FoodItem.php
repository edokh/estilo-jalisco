<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image', 'available', 'order'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getActiveDiscount()
    {
        return $this->discounts()
            ->where('active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }

    public function getPriceWithDiscount()
    {
        $discount = $this->getActiveDiscount();
        if (!$discount) return $this->price;

        if ($discount->type === 'percentage') {
            return $this->price - ($this->price * $discount->value / 100);
        } else {
            return max(0, $this->price - $discount->value);
        }
    }
}
