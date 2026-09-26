<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Order;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        // جلب طلبات العميل السابقة مرتبة تنازلياً
        $orders = Order::where('user_id', $user->id)->latest()->get();
        
        // جلب المنتجات المفضلة مع بيانات المنتج المرتبط بها
        $favorites = Favorite::where('user_id', $user->id)->with('menuItem')->get();

        return view('profile.edit', compact('user', 'orders', 'favorites'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'تم تحديث بيانات الملف الشخصي بنجاح.');
    }

    public function toggleFavorite($id)
    {
        $userId = Auth::id();
        $favorite = Favorite::where('user_id', $userId)->where('menu_item_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'تمت الإزالة من المفضلة.');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'menu_item_id' => $id
            ]);
            return back()->with('success', 'تمت الإضافة إلى المفضلة.');
        }
    }
}