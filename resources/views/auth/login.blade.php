<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول لوحة التحكم - كافيتريا الذكاء الاصطناعي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white/95 backdrop-blur-md w-full max-w-md p-8 rounded-3xl shadow-2xl border border-slate-100">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-900 text-white rounded-2xl shadow-lg text-3xl mb-4">
                📊
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">لوحة تحكم الطلبات</h1>
            <p class="text-slate-500 text-sm mt-1">الرجاء إدخال بيانات المشرف للمتابعة</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl mb-6 text-center text-sm font-semibold shadow-xs animate-pulse">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-5">
            @csrf
            
            <div>
                <label class="block mb-2 font-bold text-slate-700 text-xs uppercase tracking-wider">البريد الإلكتروني</label>
                <div class="relative">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">✉️</span>
                    <input type="email" name="email" required placeholder="name@example.com" autocomplete="off"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl pr-11 pl-4 py-3.5 focus:outline-none focus:border-slate-900 focus:bg-white transition text-slate-800 text-sm font-medium">
                </div>
            </div>

            <div>
                <label class="block mb-2 font-bold text-slate-700 text-xs uppercase tracking-wider">كلمة المرور</label>
                <div class="relative">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">🔒</span>
                    <input type="password" name="password" required placeholder="••••••••••••"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl pr-11 pl-4 py-3.5 focus:outline-none focus:border-slate-900 focus:bg-white transition text-slate-800 text-sm font-medium">
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white py-4 rounded-2xl font-bold transition shadow-lg shadow-slate-900/20 active:scale-[0.99]">
                تسجيل الدخول 🚀
            </button>
        </form>

        <!-- زرار العودة للمنيو -->
        <div class="mt-6 text-center border-t border-slate-100 pt-5">
            <a href="/menu" class="inline-flex items-center justify-center gap-2 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-3.5 rounded-2xl font-bold transition text-sm">
                <span>🍔</span> العودة إلى صفحة المنيو والموقع
            </a>
        </div>
    </div>

</body>
</html>