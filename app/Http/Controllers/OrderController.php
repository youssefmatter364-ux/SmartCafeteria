<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'total' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'total_price' => $request->total,
                'status' => 'pending',
                'payment_status' => 'unpaid'
            ]);

            foreach ($request->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => 'food', 
                    'item_id' => $item['id'] ?? 1,       
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'], 
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل طلبك بنجاح!',
                'order_id' => $order->id
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الحفظ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function adminIndex(Request $request)
    {
        $orders = Order::with('items')
                ->where('status', 'pending')        
                ->latest()
                ->get();
                
        return view('cafeteria.admin.orders', compact('orders'));
    }

    public function allOrdersIndex()
    {
        $orders = Order::with('items')->latest()->get();
        return view('cafeteria.admin.orders', compact('orders'));
    }

    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'confirmed']);
        return back()->with('success', 'تم تأكيد الحجز بنجاح!');
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'تم إلغاء الحجز.');
    }
}