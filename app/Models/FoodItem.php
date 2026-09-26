<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'item_id')
            ->where('item_type', 'food');
    }
}