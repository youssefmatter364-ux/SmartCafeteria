<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // السماح بتعبئة الحقول لتجنب مشاكل Mass Assignment
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_status'
    ];

    // تعريف العلاقة مع جدول order_items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}