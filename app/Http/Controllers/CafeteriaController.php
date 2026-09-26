<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Beverage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CafeteriaController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('query'));

        // جلب التصنيفات مع تصفية الأطباق بناءً على البحث أو إحضارها كاملة
        $categories = Category::with([
            'foodItems' => function ($q) use ($query) {

                if (!empty($query)) {

                    $keywords = explode(' ', $query);

                    $q->where(function ($subQuery) use ($keywords, $query) {

                        foreach ($keywords as $word) {

                            if (mb_strlen($word) > 1) {

                                $subQuery->orWhere('name', 'LIKE', "%{$word}%")
                                    ->orWhere('description', 'LIKE', "%{$word}%");
                            }
                        }

                        // بحث ذكي بالأسعار لو المستخدم كتب رقم أو أقل من
                        if (
                            str_contains($query, 'أقل') ||
                            str_contains($query, 'تحت') ||
                            str_contains($query, 'بـ')
                        ) {

                            preg_match('/\d+/', $query, $matches);

                            if (!empty($matches[0])) {
                                $subQuery->orWhere('price', '<=', $matches[0]);
                            }
                        }
                    });
                }
            },
            'beverages'
        ])->get();

        $userPreference = Auth::check()
            ? Auth::user()->preferences
            : null;

        // حساب نسبة التوافق بالذكاء الاصطناعي لكل وجبة طعام
        $categories->each(function ($category) use ($userPreference) {

            $category->foodItems = $category->foodItems->map(function ($food) use ($userPreference) {

                $matchScore = 50;

                if ($userPreference) {

                    if (
                        $userPreference->max_budget &&
                        $food->price <= $userPreference->max_budget
                    ) {
                        $matchScore += 20;
                    }

                    if (
                        isset($food->spicy_level) &&
                        $food->spicy_level == $userPreference->spicy_level
                    ) {
                        $matchScore += 15;
                    }

                    if (!empty($userPreference->favorite_ingredients)) {

                        $favs = array_map(
                            'trim',
                            explode(',', $userPreference->favorite_ingredients)
                        );

                        foreach ($favs as $fav) {

                            if (
                                !empty($fav) &&
                                stripos(
                                    $food->description ?? '',
                                    $fav
                                ) !== false
                            ) {
                                $matchScore += 10;
                                break;
                            }
                        }
                    }

                    if (!empty($userPreference->disliked_ingredients)) {

                        $dislikes = array_map(
                            'trim',
                            explode(',', $userPreference->disliked_ingredients)
                        );

                        foreach ($dislikes as $dislike) {

                            if (
                                !empty($dislike) &&
                                stripos(
                                    $food->description ?? '',
                                    $dislike
                                ) !== false
                            ) {
                                $matchScore -= 30;
                                break;
                            }
                        }
                    }
                }

                $food->ai_match_percentage = max(
                    10,
                    min(99, $matchScore)
                );

                return $food;

            })->sortByDesc('ai_match_percentage');
        });

        // التأكد من توجيه الطلب لصفحة المنيو مع تمرير متغير البحث
        return view(
            'cafeteria.menu',
            compact('categories', 'query')
        );
    }

    /**
     * ميزة الذكاء الاصطناعي المتقدمة: تحويل البحث لدالة الـ index مباشرة
     */
    public function aiSearch(Request $request)
    {
        return $this->index($request);
    }

    public function showItem($type, $id)
    {
        if ($type === 'food') {

            $item = FoodItem::with('category')->findOrFail($id);

        } elseif ($type === 'beverage') {

            $item = Beverage::with('category')->findOrFail($id);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Invalid item type'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }
}
