<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_phone', 'customer_email',
        'customer_notes', 'status', 'original_price', 'discount_amount', 'final_price',
        'paid', 'paid_at'
    ];

    protected $casts = [
        'paid' => 'boolean',
        'paid_at' => 'datetime',
        'original_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order_number) {
                $model->order_number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }
}
