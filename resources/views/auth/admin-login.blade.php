<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>تسجيل دخول الأدمن - Smart Cafeteria</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-900 flex items-center justify-center px-4">

<div class="w-full max-w-md">

    <div class="bg-white rounded-3xl shadow-2xl p-8">

        {{-- Logo --}}
        <div class="text-center mb-8">

            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl">
                ⚡
            </div>

            <h1 class="text-2xl font-black text-slate-900">
                لوحة تحكم الأدمن
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                تسجيل الدخول لإدارة الكافيتريا
            </p>

        </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-5 text-sm font-bold">
                {{ session('success') }}
            </div>

        @endif


        {{-- Error Message --}}
        @if(session('error'))

            <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-4 mb-5 text-sm font-bold">
                {{ session('error') }}
            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-4 mb-5 text-sm">

                @foreach($errors->all() as $error)

                    <div class="mb-1 last:mb-0">
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- Admin Login Form --}}
        <form
            action="{{ route('admin.login.store') }}"
            method="POST"
            class="space-y-5"
        >

            @csrf


            {{-- Email --}}
            <div>

                <label class="block text-sm font-bold text-slate-700 mb-2">
                    البريد الإلكتروني
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="admin@gmail.com"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                >

            </div>


            {{-- Password --}}
            <div>

                <label class="block text-sm font-bold text-slate-700 mb-2">
                    كلمة المرور
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="********"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                >

            </div>


            {{-- Login Button --}}
            <button
                type="submit"
                class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-black py-3 rounded-xl transition cursor-pointer"
            >
                تسجيل الدخول 🔐
            </button>

        </form>


        {{-- Customer Login --}}
        <div class="text-center mt-6 pt-6 border-t border-slate-100">

            <p class="text-sm text-slate-500 mb-2">
                أنت عميل؟
            </p>

            <a
                href="{{ route('login') }}"
                class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-bold"
            >
                تسجيل دخول العملاء
            </a>

        </div>

    </div>

</div>

</body>
</html>