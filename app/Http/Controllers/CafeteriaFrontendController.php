<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CafeteriaFrontendController extends Controller
{
    public function index(Request $request)
    {
        // استلام كلمة البحث وتنظيفها من المسافات
        $query = trim($request->input('query', ''));

        // قائمة المنتجات الأساسية
        $categories = [
            (object)[
                'name' => 'الوجبات السريعة والبرجر',
                'type' => 'food',
                'foodItems' => [
                    (object)['name' => 'تشيز برجر ديلوكس', 'description' => 'برجر لحم شهي مع جبنة إضافية وصوص خاص', 'price' => 85.00],
                    (object)['name' => 'دجاج زِنجر حار', 'description' => 'سندوتش دجاج مقرمش وسبايسي مع الخس', 'price' => 75.00],
                    (object)['name' => 'بيج كينج لحم', 'description' => 'طبقتين من اللحم المشوي على الفحم مع الجبنة', 'price' => 110.00],
                    (object)['name' => 'تويستر دجاج', 'description' => 'قطع دجاج مقرمشة ملفوفة في خبز التورتيلا', 'price' => 65.00],
                ],
                'beverages' => []
            ],
            (object)[
                'name' => 'البيتزا والمعجنات',
                'type' => 'food',
                'foodItems' => [
                    (object)['name' => 'بيتزا مارجريتا', 'description' => 'جبنة موتساريلا طازجة وصوص طماطم وأعشاب', 'price' => 120.00],
                    (object)['name' => 'بيتزا رانچ دجاج', 'description' => 'قطع دجاج طرية مع صوص الرانچ والجبنة المذابة', 'price' => 145.00],
                    (object)['name' => 'فطيرة مكس جبن', 'description' => 'مزيج فاخر من الجبن الرومي والموتساريلا والشيدر', 'price' => 90.00],
                ],
                'beverages' => []
            ],
            (object)[
                'name' => 'المشروبات الباردة والمنعشة',
                'type' => 'beverage',
                'foodItems' => [],
                'beverages' => [
                    (object)['name' => 'ايس كوفي مثلج', 'description' => 'قهوة باردة منعشة بالحليب والثلج', 'price' => 45.00],
                    (object)['name' => 'عصير مانجو طازج', 'description' => 'مانجو طبيعي 100% ومثلج', 'price' => 40.00],
                    (object)['name' => 'ميلك شيك فراولة', 'description' => 'آيس كريم فانيليا مع صوص الفراولة الطازج', 'price' => 50.00],
                    (object)['name' => 'موهيتو ليمون ونعناع', 'description' => 'مشروب غازي منعش مع النعناع والليمون الصقيعي', 'price' => 45.00],
                ]
            ],
            (object)[
                'name' => 'المشروبات الساخنة',
                'type' => 'beverage',
                'foodItems' => [],
                'beverages' => [
                    (object)['name' => 'إسبريسو دبل', 'description' => 'قهوة مركزة وغنية بالطاقة', 'price' => 30.00],
                    (object)['name' => 'كابتشينو رغوي', 'description' => 'إسبريسو مع حليب مبخر ورغوة غنية', 'price' => 40.00],
                    (object)['name' => 'شاي أخضر بالنعناع', 'description' => 'شاي صحي ومنعش', 'price' => 20.00],
                ]
            ]
        ];

        // تطبيق الفلترة في حال كتب المستخدم كلمة بحث
        if (!empty($query)) {
            $filteredCategories = [];

            foreach ($categories as $category) {
                $matchedFoodItems = array_filter($category->foodItems, function($item) use ($query) {
                    return mb_strpos($item->name, $query) !== false || mb_strpos($item->description, $query) !== false;
                });

                $matchedBeverages = array_filter($category->beverages, function($item) use ($query) {
                    return mb_strpos($item->name, $query) !== false || mb_strpos($item->description, $query) !== false;
                });

                if (!empty($matchedFoodItems) || !empty($matchedBeverages)) {
                    $newCategory = clone $category;
                    $newCategory->foodItems = array_values($matchedFoodItems);
                    $newCategory->beverages = array_values($matchedBeverages);
                    $filteredCategories[] = $newCategory;
                }
            }

            $categories = $filteredCategories;
        }

        return view('cafeteria.menu', compact('categories'));
    }
}