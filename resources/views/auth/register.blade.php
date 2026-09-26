<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - مطعم Y&A</title>
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
                ✨
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">حساب جديد في المنهج الذكي</h1>
            <p class="text-slate-500 text-sm mt-1">أنشئ حسابك واستمتع بالطلب المباشر</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl mb-6 text-center text-sm font-semibold shadow-xs animate-pulse">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block mb-1 font-bold text-slate-700 text-xs uppercase tracking-wider">الاسم الكامل</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="اسمك الكريم"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:border-slate-900 focus:bg-white transition text-slate-800 text-sm font-medium">
            </div>

            <div>
                <label class="block mb-1 font-bold text-slate-700 text-xs uppercase tracking-wider">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:border-slate-900 focus:bg-white transition text-slate-800 text-sm font-medium">
            </div>

            <div>
                <label class="block mb-1 font-bold text-slate-700 text-xs uppercase tracking-wider">كلمة المرور</label>
                <input type="password" name="password" required placeholder="••••••••••••"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:border-slate-900 focus:bg-white transition text-slate-800 text-sm font-medium">
            </div>

            <div>
                <label class="block mb-1 font-bold text-slate-700 text-xs uppercase tracking-wider">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••••••"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:border-slate-900 focus:bg-white transition text-slate-800 text-sm font-medium">
            </div>

            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white py-3.5 rounded-2xl font-bold transition shadow-lg shadow-slate-900/20 active:scale-[0.99] mt-2">
                تسجيل الحساب 🚀
            </button>
        </form>

        <div class="mt-6 text-center border-t border-slate-100 pt-5 space-y-3">
            <a href="{{ route('login') }}" class="block text-slate-600 hover:text-slate-900 text-xs font-bold transition">
                لديك حساب بالفعل؟ <span class="text-amber-600 underline">تسجيل الدخول</span>
            </a>
            <a href="/menu" class="inline-flex items-center justify-center gap-2 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 rounded-2xl font-bold transition text-sm">
                <span>🍔</span> العودة إلى صفحة المنيو والموقع
            </a>
        </div>
    </div>

</body>
</html>