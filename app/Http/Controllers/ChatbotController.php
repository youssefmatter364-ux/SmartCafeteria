<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Beverage;
use App\Models\Category;
use App\Models\User;
use App\Models\ActivityLog;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = trim(strtolower($request->input('message')));

        // 1. أسئلة ترحيبية
        if (str_contains($message, 'مرحبا') || str_contains($message, 'اهلاً') || str_contains($message, 'سلام') || str_contains($message, 'hello') || str_contains($message, 'hi')) {
            return response()->json([
                'reply' => 'أهلاً بيك يا بشمهندس يوسف في لوحة التحكم ⚡! أنا مساعدك الذكي، أقدر أساعدك في إدارة المنيو أو أقولك مين مسجل دخول حالياً.'
            ]);
        }

        // 2. معرفة مين مسجل دخول ومین لا (حسب الطلب الجديد)
        if (str_contains($message, 'مين سجل دخول') || str_contains($message, 'المسجلين') || str_contains($message, 'الدخول') || str_contains($message, 'online') || str_contains($message, 'الحالة')) {
            $users = User::all();
            
            $reply = "👥 **حالة تسجيل دخول المستخدمين:**\n\n";
            
            foreach ($users as $user) {
                // جلب آخر حركة لهذا المستخدم من جدول النشاطات إن وجد
                $lastLog = class_exists(ActivityLog::class) 
                    ? ActivityLog::where('user_id', $user->id)->latest()->first() 
                    : null;

                $status = "خارج النظام (Offline) ⚪";
                
                if ($lastLog && $lastLog->type === 'login') {
                    $status = "مسجل دخول (Online) 🟢";
                } elseif ($lastLog && $lastLog->type === 'logout') {
                    $status = "مغادر (Offline) 🔴";
                }

                $reply .= "👤 **{$user->name}** ({$user->email})\nالحالة: {$status}\n\n";
            }

            return response()->json(['reply' => $reply]);
        }

        // 3. لو بيسأل عن المنيو أو الأكل أو المشروبات
        if (str_contains($message, 'منيو') || str_contains($message, 'قائمة') || str_contains($message, 'أكل') || str_contains($message, 'وجبات')) {
            $foods = FoodItem::where('is_available', true)->take(5)->pluck('name')->toArray();
            $beverages = Beverage::where('is_available', true)->take(5)->pluck('name')->toArray();
            
            $reply = "📋 **منيو كافيتريا الذكاء الاصطناعي المتاح حالياً:**\n\n";
            if(count($foods) > 0) {
                $reply .= "🍔 **أطعمة:** " . implode(', ', $foods) . "\n";
            }
            if(count($beverages) > 0) {
                $reply .= "🥤 **مشروبات:** " . implode(', ', $beverages) . "\n";
            }
            if(count($foods) == 0 && count($beverages) == 0) {
                $reply = "عذراً، المنيو فارغ حالياً أو المنتجات غير متوفرة.";
            }

            return response()->json(['reply' => $reply]);
        }

        // 4. لو بيسأل عن الأسعار
        if (str_contains($message, 'سعر') || str_contains($message, 'أسعار') || str_contains($message, 'بكام')) {
            $foodPrices = FoodItem::where('is_available', true)->select('name', 'price')->get();
            $bevPrices = Beverage::where('is_available', true)->select('name', 'price')->get();

            $reply = "💰 **أسعار المنتجات المتوفرة:**\n";
            foreach($foodPrices as $item) {
                $reply .= "- {$item->name}: {$item->price} ج.م\n";
            }
            foreach($bevPrices as $item) {
                $reply .= "- {$item->name}: {$item->price} ج.م\n";
            }

            return response()->json(['reply' => $reply]);
        }

        // 5. الرد على أي سؤال آخر بشكل ذكي (حسب طلبك: رد على أي سؤال)
        return response()->json([
            'reply' => "🤖 لقد استقبلت سؤالك: \"{$request->input('message')}\". بصفتي مساعدك الذكي في لوحة التحكم، يمكنك سؤالي عن: (المنيو، الأسعار، أو كتابة: مين سجل دخول؟ لمعرفة حالة المستخدمين)."
        ]);
    }
}