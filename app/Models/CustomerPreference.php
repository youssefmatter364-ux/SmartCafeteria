<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'favorite_categories',
        'preferred_taste',
        'dietary_preferences',
        'max_budget',
        'spicy_level',
        'favorite_ingredients',
        'disliked_ingredients',
    ];

    // علاقة التفضيلات بالمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}