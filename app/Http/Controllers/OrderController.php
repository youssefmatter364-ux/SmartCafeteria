<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\FoodItem;
use App\Models\Beverage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('ORDER STORE REACHED', [
            'user_id' => Auth::id(),
            'logged_in' => Auth::check(),
        ]);

        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer',
            'cart.*.type' => 'required|in:food,beverage',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً.'
            ], 401);
        }

        try {
            DB::beginTransaction();

            $total = 0;
            $orderItems = [];

            foreach ($request->cart as $item) {

                if ($item['type'] === 'food') {
                    $product = FoodItem::where('id', $item['id'])
                        ->where('is_available', true)
                        ->first();
                } else {
                    $product = Beverage::where('id', $item['id'])
                        ->where('is_available', true)
                        ->first();
                }

                if (!$product) {
                    throw new \Exception('أحد المنتجات لم يعد متاحًا.');
                }

                $quantity = (int) $item['quantity'];
                $price = (float) $product->price;
                $subtotal = $price * $quantity;

                $total += $subtotal;

                $orderItems[] = [
                    'item_type' => $item['type'],
                    'item_id' => $product->id,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }

            // إنشاء الطلب وربطه بمستخدم الجلسة الحالي
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // تسجيل النشاط لو ActivityLog موجود
            if (class_exists(ActivityLog::class)) {
                try {
                    ActivityLog::create([
                        'user_id' => Auth::id(),
                        'action_description' => 'تم إنشاء طلب جديد برقم: #' . $order->id,
                        'type' => 'order_created',
                    ]);
                } catch (\Throwable $e) {
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل طلبك بنجاح! في انتظار موافقة الإدارة.',
                'order_id' => $order->id,
                'total' => $total,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function myOrders()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('cafeteria.my-orders', compact('orders'));
    }

    public function cancelCustomerOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with('error', 'لا يمكن إلغاء هذا الطلب الآن.');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'تم إلغاء الطلب.');
    }
}