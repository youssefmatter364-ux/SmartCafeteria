<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerPreference;
use Illuminate\Support\Facades\Auth;

class CustomerPreferenceController extends Controller
{
    // عرض صفحة إدخال التفضيلات للعميل
    public function edit()
    {
        $preference = Auth::user()->preferences ?? new CustomerPreference();
        return view('cafeteria.preferences', compact('preference'));
    }

    // حفظ أو تحديث تفضيلات العميل
    public function update(Request $request)
    {
        $validated = $request->validate([
            'favorite_categories' => 'nullable|string',
            'preferred_taste' => 'nullable|string',
            'dietary_preferences' => 'nullable|string',
            'max_budget' => 'nullable|numeric',
            'spicy_level' => 'nullable|integer|min:0|max:3',
            'favorite_ingredients' => 'nullable|string',
            'disliked_ingredients' => 'nullable|string',
        ]);

        Auth::user()->preferences()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->back()->with('success', 'تم حفظ تفضيلاتك بنجاح! الجاهزية للذكاء الاصطناعي أصبحت تفعيل كامل.');
    }
}