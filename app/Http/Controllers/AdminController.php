<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Beverage;
use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::with(['items', 'user'])
            ->latest()
            ->get();

        $categories = Category::with(['foodItems', 'beverages'])
            ->latest()
            ->get();

        $foodItems = FoodItem::with('category')
            ->latest()
            ->get();

        $beverages = Beverage::with('category')
            ->latest()
            ->get();

        $activityLogs = class_exists(ActivityLog::class)
            ? ActivityLog::with('user')
                ->latest()
                ->take(10)
                ->get()
            : collect();

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'food' => FoodItem::count(),
            'beverages' => Beverage::count(),
            'categories' => Category::count(),
        ];

        return view(
            'cafeteria.admin.orders',
            compact(
                'orders',
                'categories',
                'foodItems',
                'beverages',
                'activityLogs',
                'stats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN LOGIN
    |--------------------------------------------------------------------------
    */

    public function login()
    {
        if (Auth::check()) {

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.orders');
            }

            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return view('auth.admin-login');
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN AUTHENTICATION
    |--------------------------------------------------------------------------
    */

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors([
                    'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }


        $request->session()->regenerate();


        $user = Auth::user();


        if (!$user || $user->role !== 'admin') {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' => 'هذا الحساب ليس حساب أدمن. استخدم حساب الأدمن للدخول إلى لوحة التحكم.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }


        if (class_exists(ActivityLog::class)) {

            try {

                ActivityLog::create([
                    'user_id' => $user->id,

                    'action_description' =>
                        'تسجيل دخول الأدمن: '
                        . $user->name
                        . ' ('
                        . $user->email
                        . ')',

                    'type' => 'login',
                ]);

            } catch (\Throwable $e) {
                // لا نوقف تسجيل الدخول لو الـ ActivityLog فيه مشكلة
            }
        }


        return redirect()
            ->route('admin.orders')
            ->with(
                'success',
                'مرحباً بك يا أدمن '
                . $user->name
                . ' 👋'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $user = Auth::user();


        if ($user && class_exists(ActivityLog::class)) {

            try {

                ActivityLog::create([
                    'user_id' => $user->id,

                    'action_description' =>
                        'تسجيل خروج المستخدم: '
                        . $user->name,

                    'type' => 'logout',
                ]);

            } catch (\Throwable $e) {
                // لا نمنع تسجيل الخروج لو الـ Log فيه مشكلة
            }
        }


        Auth::logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'تم تسجيل الخروج بنجاح.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Categories Management
    |--------------------------------------------------------------------------
    */

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:food,beverage',
            ],
        ]);

        Category::create($validated);

        return back()->with(
            'success',
            'تم إضافة التصنيف بنجاح ✅'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Menu Management
    |--------------------------------------------------------------------------
    */

    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'in:food,beverage',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);


        $category = Category::findOrFail(
            $validated['category_id']
        );


        if ($category->type !== $validated['type']) {

            return back()->with(
                'error',
                'نوع المنتج لا يتوافق مع نوع التصنيف المحدد.'
            );
        }


        $data = [
            'category_id' => $validated['category_id'],

            'name' => $validated['name'],

            'description' =>
                $validated['description'] ?? null,

            'price' => $validated['price'],

            'is_available' => true,
        ];


        if ($validated['type'] === 'food') {

            FoodItem::create($data);

        } else {

            Beverage::create($data);
        }


        return back()->with(
            'success',
            'تم إضافة المنتج إلى المنيو بنجاح 🍔✨'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Food
    |--------------------------------------------------------------------------
    */

    public function updateFood(Request $request, $id)
    {
        $food = FoodItem::findOrFail($id);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $food->update($validated);

        return back()->with(
            'success',
            'تم تعديل الوجبة بنجاح ✅'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Beverage
    |--------------------------------------------------------------------------
    */

    public function updateBeverage(Request $request, $id)
    {
        $beverage = Beverage::findOrFail($id);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $beverage->update($validated);

        return back()->with(
            'success',
            'تم تعديل المشروب بنجاح ✅'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Food
    |--------------------------------------------------------------------------
    */

    public function deleteFood($id)
    {
        $food = FoodItem::findOrFail($id);

        $food->delete();

        return back()->with(
            'success',
            'تم حذف الوجبة بنجاح 🗑️'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Beverage
    |--------------------------------------------------------------------------
    */

    public function deleteBeverage($id)
    {
        $beverage = Beverage::findOrFail($id);

        $beverage->delete();

        return back()->with(
            'success',
            'تم حذف المشروب بنجاح 🗑️'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Food
    |--------------------------------------------------------------------------
    */

    public function toggleFood($id)
    {
        $food = FoodItem::findOrFail($id);

        $food->update([
            'is_available' => !$food->is_available,
        ]);

        return back()->with(
            'success',
            'تم تغيير حالة الوجبة بنجاح.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Beverage
    |--------------------------------------------------------------------------
    */

    public function toggleBeverage($id)
    {
        $beverage = Beverage::findOrFail($id);

        $beverage->update([
            'is_available' => !$beverage->is_available,
        ]);

        return back()->with(
            'success',
            'تم تغيير حالة المشروب بنجاح.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Confirm Order
    |--------------------------------------------------------------------------
    */

    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);


        if ($order->status !== 'pending') {

            return back()->with(
                'error',
                'هذا الطلب تم التعامل معه بالفعل.'
            );
        }


        $order->update([
            'status' => 'confirmed',
        ]);


        if (class_exists(ActivityLog::class)) {

            try {

                ActivityLog::create([
                    'user_id' => Auth::id(),

                    'action_description' =>
                        'تم تأكيد الطلب رقم: #'
                        . $order->id,

                    'type' => 'order_confirmed',
                ]);

            } catch (\Throwable $e) {
                // تجاهل خطأ الـ ActivityLog
            }
        }


        return back()->with(
            'success',
            'تم تأكيد الطلب بنجاح ✅'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Cancel Order
    |--------------------------------------------------------------------------
    */

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);


        if ($order->status !== 'pending') {

            return back()->with(
                'error',
                'هذا الطلب تم التعامل معه بالفعل.'
            );
        }


        $order->update([
            'status' => 'cancelled',
        ]);


        if (class_exists(ActivityLog::class)) {

            try {

                ActivityLog::create([
                    'user_id' => Auth::id(),

                    'action_description' =>
                        'تم إلغاء الطلب رقم: #'
                        . $order->id,

                    'type' => 'order_cancelled',
                ]);

            } catch (\Throwable $e) {
                // تجاهل خطأ الـ ActivityLog
            }
        }


        return back()->with(
            'success',
            'تم رفض الطلب ❌'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Chatbot
    |--------------------------------------------------------------------------
    */

    public function chatbotRespond(Request $request)
    {
        $message = trim(
            $request->input('message', '')
        );

        $lowerMessage = mb_strtolower(
            $message
        );


        /*
        |--------------------------------------------------------------------------
        | سؤال فاضي
        |--------------------------------------------------------------------------
        */

        if ($message === '') {

            return response()->json([
                'reply' => 'اكتب سؤالك وأنا هساعدك 👍'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | مين سجل دخول؟
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($lowerMessage, 'مين سجل دخول')
            ||
            str_contains($lowerMessage, 'مين مسجل')
            ||
            str_contains($lowerMessage, 'مسجل دخول')
            ||
            str_contains($lowerMessage, 'من سجل دخول')
            ||
            str_contains($lowerMessage, 'الأدمن الحالي')
        ) {

            $user = Auth::user();

            if ($user) {

                $reply =
                    "👤 المستخدم المسجل دخول حالياً:\n"
                    . "الاسم: {$user->name}\n"
                    . "الإيميل: {$user->email}\n"
                    . "الصلاحية: {$user->role}";

            } else {

                $reply =
                    'لا يوجد مستخدم مسجل دخول حالياً.';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | عدد المستخدمين
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'عدد المستخدمين')
            ||
            str_contains($lowerMessage, 'كام مستخدم')
            ||
            str_contains($lowerMessage, 'المستخدمين كام')
            ||
            str_contains($lowerMessage, 'العملاء كام')
        ) {

            $usersCount =
                \App\Models\User::count();

            $reply =
                "👥 عدد المستخدمين المسجلين في النظام: "
                . "{$usersCount} مستخدم.";
        }


        /*
        |--------------------------------------------------------------------------
        | إحصائيات الطلبات
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'إحصائيات الطلبات')
            ||
            str_contains($lowerMessage, 'احصائيات الطلبات')
            ||
            str_contains($lowerMessage, 'كم طلب')
            ||
            str_contains($lowerMessage, 'كام طلب')
            ||
            str_contains($lowerMessage, 'عدد الطلبات')
            ||
            str_contains($lowerMessage, 'الطلبات كام')
            ||
            str_contains($lowerMessage, 'حالة الطلبات')
        ) {

            $pendingCount =
                Order::where(
                    'status',
                    'pending'
                )->count();

            $confirmedCount =
                Order::where(
                    'status',
                    'confirmed'
                )->count();

            $cancelledCount =
                Order::where(
                    'status',
                    'cancelled'
                )->count();

            $totalOrders =
                Order::count();


            $reply =
                "📊 إحصائيات الطلبات:\n\n"
                . "📦 إجمالي الطلبات: {$totalOrders}\n"
                . "⏳ الطلبات المعلقة: {$pendingCount}\n"
                . "✅ الطلبات المؤكدة: {$confirmedCount}\n"
                . "❌ الطلبات الملغية: {$cancelledCount}";
        }


        /*
        |--------------------------------------------------------------------------
        | الطلبات المعلقة
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'الطلبات المعلقة')
            ||
            str_contains($lowerMessage, 'طلبات معلقة')
            ||
            str_contains($lowerMessage, 'كام طلب معلق')
            ||
            str_contains($lowerMessage, 'كم طلب معلق')
        ) {

            $count =
                Order::where(
                    'status',
                    'pending'
                )->count();

            $reply =
                "⏳ يوجد حالياً {$count} طلب معلق "
                . "في انتظار التعامل معه.";
        }


        /*
        |--------------------------------------------------------------------------
        | الطلبات المؤكدة
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'الطلبات المؤكدة')
            ||
            str_contains($lowerMessage, 'طلبات مؤكدة')
            ||
            str_contains($lowerMessage, 'كام طلب مؤكد')
            ||
            str_contains($lowerMessage, 'كم طلب مؤكد')
        ) {

            $count =
                Order::where(
                    'status',
                    'confirmed'
                )->count();

            $reply =
                "✅ يوجد حالياً {$count} طلب مؤكد.";
        }


        /*
        |--------------------------------------------------------------------------
        | الطلبات الملغية
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'الطلبات الملغية')
            ||
            str_contains($lowerMessage, 'طلبات ملغية')
            ||
            str_contains($lowerMessage, 'كام طلب ملغي')
            ||
            str_contains($lowerMessage, 'كم طلب ملغي')
        ) {

            $count =
                Order::where(
                    'status',
                    'cancelled'
                )->count();

            $reply =
                "❌ يوجد حالياً {$count} طلب ملغي.";
        }


        /*
        |--------------------------------------------------------------------------
        | آخر الطلبات
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'آخر الطلبات')
            ||
            str_contains($lowerMessage, 'اخر الطلبات')
            ||
            str_contains($lowerMessage, 'الطلبات الأخيرة')
            ||
            str_contains($lowerMessage, 'اخر طلبات')
        ) {

            $orders = Order::with('user')
                ->latest()
                ->take(5)
                ->get();

            if ($orders->count() === 0) {

                $reply =
                    '📭 لا توجد طلبات حالياً.';

            } else {

                $reply =
                    "📦 آخر الطلبات:\n\n";

                foreach ($orders as $order) {

                    $userName =
                        $order->user->name ?? 'زائر';

                    $status =
                        $order->status === 'pending'
                            ? '⏳ معلق'
                            : (
                                $order->status === 'confirmed'
                                    ? '✅ مؤكد'
                                    : '❌ ملغي'
                            );

                    $reply .=
                        "طلب #{$order->id} - {$userName}\n"
                        . "الحالة: {$status}\n"
                        . "الإجمالي: {$order->total_price} ج.م\n\n";
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | إجمالي المبيعات
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'إجمالي المبيعات')
            ||
            str_contains($lowerMessage, 'اجمالي المبيعات')
            ||
            str_contains($lowerMessage, 'المبيعات كام')
            ||
            str_contains($lowerMessage, 'إجمالي الإيرادات')
            ||
            str_contains($lowerMessage, 'اجمالي الإيرادات')
        ) {

            $sales =
                Order::where(
                    'status',
                    'confirmed'
                )->sum('total_price');

            $reply =
                "💰 إجمالي قيمة الطلبات المؤكدة: "
                . "{$sales} ج.م";
        }


        /*
        |--------------------------------------------------------------------------
        | عدد الأكلات
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'عدد الأكلات')
            ||
            str_contains($lowerMessage, 'عدد الوجبات')
            ||
            str_contains($lowerMessage, 'كام أكلة')
            ||
            str_contains($lowerMessage, 'كام اكلة')
            ||
            str_contains($lowerMessage, 'الوجبات كام')
        ) {

            $count =
                FoodItem::count();

            $reply =
                "🍔 عدد الوجبات الموجودة في النظام: "
                . "{$count} وجبة.";
        }


        /*
        |--------------------------------------------------------------------------
        | عدد المشروبات
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'عدد المشروبات')
            ||
            str_contains($lowerMessage, 'كام مشروب')
            ||
            str_contains($lowerMessage, 'المشروبات كام')
        ) {

            $count =
                Beverage::count();

            $reply =
                "🥤 عدد المشروبات الموجودة في النظام: "
                . "{$count} مشروب.";
        }


        /*
        |--------------------------------------------------------------------------
        | عدد التصنيفات
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'عدد التصنيفات')
            ||
            str_contains($lowerMessage, 'كام تصنيف')
            ||
            str_contains($lowerMessage, 'التصنيفات كام')
        ) {

            $count =
                Category::count();

            $reply =
                "📁 عدد التصنيفات الموجودة: "
                . "{$count} تصنيف.";
        }


        /*
        |--------------------------------------------------------------------------
        | معلومات المنيو
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'المنيو')
            ||
            str_contains($lowerMessage, 'معلومات المنيو')
            ||
            str_contains($lowerMessage, 'المنتجات الموجودة')
            ||
            str_contains($lowerMessage, 'ايه المنتجات')
            ||
            str_contains($lowerMessage, 'إيه المنتجات')
        ) {

            $foodCount =
                FoodItem::count();

            $beverageCount =
                Beverage::count();

            $categoriesCount =
                Category::count();

            $availableFood =
                FoodItem::where(
                    'is_available',
                    true
                )->count();

            $availableBeverages =
                Beverage::where(
                    'is_available',
                    true
                )->count();


            $reply =
                "🍔 معلومات المنيو:\n\n"
                . "📁 التصنيفات: {$categoriesCount}\n"
                . "🍔 إجمالي الوجبات: {$foodCount}\n"
                . "🥤 إجمالي المشروبات: {$beverageCount}\n"
                . "✅ الوجبات المتاحة: {$availableFood}\n"
                . "✅ المشروبات المتاحة: {$availableBeverages}";
        }


        /*
        |--------------------------------------------------------------------------
        | المنتجات المتاحة
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'المنتجات المتاحة')
            ||
            str_contains($lowerMessage, 'الأكل المتاح')
            ||
            str_contains($lowerMessage, 'الاكل المتاح')
            ||
            str_contains($lowerMessage, 'المتاح في المنيو')
        ) {

            $foods =
                FoodItem::where(
                    'is_available',
                    true
                )->get();

            $beverages =
                Beverage::where(
                    'is_available',
                    true
                )->get();


            $reply =
                "✅ المنتجات المتاحة حالياً:\n\n";


            if ($foods->count() > 0) {

                $reply .=
                    "🍔 الوجبات:\n";

                foreach ($foods as $food) {

                    $reply .=
                        "- {$food->name} : "
                        . "{$food->price} ج.م\n";
                }
            }


            if ($beverages->count() > 0) {

                $reply .=
                    "\n🥤 المشروبات:\n";

                foreach ($beverages as $beverage) {

                    $reply .=
                        "- {$beverage->name} : "
                        . "{$beverage->price} ج.م\n";
                }
            }


            if (
                $foods->count() === 0
                &&
                $beverages->count() === 0
            ) {

                $reply =
                    '📭 لا توجد منتجات متاحة حالياً.';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | المنتجات غير المتاحة
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'غير المتاحة')
            ||
            str_contains($lowerMessage, 'غير متاحة')
            ||
            str_contains($lowerMessage, 'المنتجات المقفولة')
            ||
            str_contains($lowerMessage, 'المنتجات غير متاحة')
        ) {

            $foods =
                FoodItem::where(
                    'is_available',
                    false
                )->get();

            $beverages =
                Beverage::where(
                    'is_available',
                    false
                )->get();


            $reply =
                "🚫 المنتجات غير المتاحة:\n\n";


            if ($foods->count() > 0) {

                $reply .=
                    "🍔 الوجبات:\n";

                foreach ($foods as $food) {

                    $reply .=
                        "- {$food->name}\n";
                }
            }


            if ($beverages->count() > 0) {

                $reply .=
                    "\n🥤 المشروبات:\n";

                foreach ($beverages as $beverage) {

                    $reply .=
                        "- {$beverage->name}\n";
                }
            }


            if (
                $foods->count() === 0
                &&
                $beverages->count() === 0
            ) {

                $reply =
                    '✅ كل المنتجات متاحة حالياً.';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Greetings
        |--------------------------------------------------------------------------
        */

        elseif (
            str_contains($lowerMessage, 'السلام عليكم')
            ||
            str_contains($lowerMessage, 'مرحبا')
            ||
            str_contains($lowerMessage, 'أهلا')
            ||
            str_contains($lowerMessage, 'أهلاً')
            ||
            str_contains($lowerMessage, 'ازيك')
            ||
            str_contains($lowerMessage, 'عامل ايه')
            ||
            str_contains($lowerMessage, 'مساعد')
        ) {

            $reply =
                "وعليكم السلام ورحمة الله وبركاته 👋\n\n"
                . "أنا مساعد لوحة التحكم الذكي 🤖\n"
                . "اسألني عن الطلبات أو المنيو أو "
                . "المستخدمين أو المبيعات وأنا هجيبلك البيانات.";
        }


        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        else {

            $reply =
                "🤖 أقدر أساعدك في حاجات كتير، "
                . "جرب تسألني مثلاً:\n\n"
                . "📦 كام طلب معلق؟\n"
                . "📊 إحصائيات الطلبات\n"
                . "👤 مين سجل دخول؟\n"
                . "👥 عدد المستخدمين كام؟\n"
                . "🍔 كام وجبة موجودة؟\n"
                . "🥤 كام مشروب موجود؟\n"
                . "📁 كام تصنيف عندنا؟\n"
                . "🍽️ إيه المنتجات المتاحة؟\n"
                . "💰 إجمالي المبيعات كام؟\n"
                . "📦 إيه آخر الطلبات؟";
        }


        return response()->json([
            'reply' => $reply,
        ]);
    }
}
