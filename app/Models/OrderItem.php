<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getProductAttribute()
    {
        if ($this->item_type === 'food') {
            return FoodItem::find($this->item_id);
        }

        if ($this->item_type === 'beverage') {
            return Beverage::find($this->item_id);
        }

        return null;
    }
}