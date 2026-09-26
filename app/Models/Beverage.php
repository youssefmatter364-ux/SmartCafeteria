<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beverage extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'item_id')
            ->where('item_type', 'beverage');
    }
}