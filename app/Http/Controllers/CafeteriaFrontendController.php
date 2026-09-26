<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CafeteriaFrontendController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('query', ''));

        $categories = Category::with([
            'foodItems' => function ($q) use ($query) {
                $q->where('is_available', true);

                if ($query !== '') {
                    $q->where(function ($search) use ($query) {
                        $search->where('name', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    });
                }
            },

            'beverages' => function ($q) use ($query) {
                $q->where('is_available', true);

                if ($query !== '') {
                    $q->where(function ($search) use ($query) {
                        $search->where('name', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    });
                }
            }
        ])->get();

        $categories->each(function ($category) {

            $category->foodItems = $category->foodItems->map(function ($food) {

                $food->ai_match_percentage = 50;

                return $food;
            });

            $category->beverages = $category->beverages->map(function ($beverage) {

                $beverage->ai_match_percentage = 50;

                return $beverage;
            });
        });

        return view('cafeteria.menu', compact(
            'categories',
            'query'
        ));
    }
}