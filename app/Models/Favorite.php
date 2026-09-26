<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_item_id',
    ];

    // علاقة المفضلة بالمنتج (تأكد أن اسم الموديل يوافق اسم موديل الأكل لديك مثل Food أو FoodItem)
    public function menuItem()
    {
        return $this->belongsTo(FoodItem::class, 'menu_item_id');
    }
}