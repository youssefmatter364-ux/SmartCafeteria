<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي | كافيتريا الذكاء الاصطناعي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen pb-12">

    <!-- Navbar مبسط -->
    <nav class="bg-slate-900/85 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-black text-white">⚡ ملفي الشخصي</h1>
            <a href="{{ route('menu') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold px-4 py-2 rounded-xl transition">العودة للمنيو</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-8 space-y-8">

        @if(session('success'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm font-bold">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- تعديل البيانات الشخصية -->
        <div class="bg-slate-900/65 border border-slate-800 p-6 rounded-3xl shadow-xl">
            <h2 class="text-md font-black text-white mb-4">👤 البيانات الأساسية</h2>
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2">الاسم</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500">
                </div>
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-black px-6 py-3 rounded-xl text-xs transition cursor-pointer">حفظ التعديلات</button>
            </form>
        </div>

        <!-- المنتجات المفضلة -->
        <div class="bg-slate-900/65 border border-slate-800 p-6 rounded-3xl shadow-xl">
            <h2 class="text-md font-black text-white mb-4">❤️ الأكلات والمشروبات المفضلة</h2>
            @if(isset($favorites) && count($favorites) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($favorites as $fav)
                        <div class="p-4 bg-slate-950 border border-slate-800 rounded-2xl flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-white text-sm">{{ $fav->menuItem->name ?? 'منتج غير متوفر' }}</h4>
                                <p class="text-xs text-amber-500 font-black mt-1">{{ $fav->menuItem->price ?? 0 }} ج.م</p>
                            </div>
                            <form action="{{ route('favorites.toggle', $fav->menu_item_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-bold bg-rose-500/10 px-3 py-1.5 rounded-xl border border-rose-500/20">إزالة</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-400 text-xs">لم تقم بإضافة أي منتجات للمفضلة حتى الآن.</p>
            @endif
        </div>

        <!-- الطلبات السابقة -->
        <div class="bg-slate-900/65 border border-slate-800 p-6 rounded-3xl shadow-xl">
            <h2 class="text-md font-black text-white mb-4">📦 سجل الطلبات السابقة</h2>
            @if(isset($orders) && count($orders) > 0)
                <div class="space-y-3">
                    @foreach($orders as $order)
                        <div class="p-4 bg-slate-950 border border-slate-800 rounded-2xl flex justify-between items-center text-xs">
                            <div>
                                <span class="font-bold text-white">طلب #{{ $order->id }}</span>
                                <span class="text-slate-400 ml-2">({{ $order->created_at->format('Y-m-d H:i') }})</span>
                            </div>
                            <span class="px-3 py-1 rounded-full font-bold {{ $order->status == 'confirmed' ? 'bg-emerald-500/10 text-emerald-400' : ($order->status == 'cancelled' ? 'bg-rose-500/10 text-rose-400' : 'bg-amber-500/10 text-amber-400') }}">
                                {{ $order->status == 'confirmed' ? 'تم التأكيد' : ($order->status == 'cancelled' ? 'ملغي' : 'قيد الانتظار') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-400 text-xs">ليس لديك أي طلبات سابقة.</p>
            @endif
        </div>

    </main>
</body>
</html>