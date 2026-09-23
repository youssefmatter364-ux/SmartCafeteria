<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Beverage;

class CafeteriaSeeder extends Seeder
{
    public function run(): void
    {
        // إضافة تصنيف طعام
        $foodCat = Category::create([
            'name' => 'Fast Food',
            'type' => 'food'
        ]);
        
        FoodItem::create([
            'category_id' => $foodCat->id,
            'name' => 'Cheeseburger',
            'description' => 'Delicious beef burger with extra cheese',
            'price' => 75.00,
            'is_available' => true
        ]);

        // إضافة تصنيف مشروبات
        $bevCat = Category::create([
            'name' => 'Cold Drinks', 
            'type' => 'beverage'
        ]);

        Beverage::create([
            'category_id' => $bevCat->id,
            'name' => 'Iced Coffee',
            'description' => 'Fresh cold brewed coffee',
            'price' => 35.00,
            'is_available' => true
        ]);
    }
}