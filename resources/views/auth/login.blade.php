<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>تسجيل الدخول - Smart Cafeteria</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>


<body class="bg-slate-100 min-h-screen flex items-center justify-center">


<div class="w-full max-w-md px-6">

    <div class="bg-white rounded-3xl shadow-xl p-8">


        {{-- Logo / Title --}}

        <div class="text-center mb-8">

            <div class="text-5xl mb-4">
                ☕
            </div>

            <h1 class="text-2xl font-bold text-slate-900">
                Smart Cafeteria
            </h1>

            <p class="text-gray-500 mt-2">
                تسجيل دخول العميل
            </p>

        </div>


        {{-- Error Messages --}}

        @if ($errors->any())

            <div class="bg-red-100 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm font-semibold">

                @foreach ($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- Success Message --}}

        @if (session('success'))

            <div class="bg-green-100 border border-green-200 text-green-700 rounded-xl p-4 mb-5 text-sm font-semibold">

                {{ session('success') }}

            </div>

        @endif


        {{-- Customer Login Form --}}

        <form
            action="{{ route('login.store') }}"
            method="POST"
            class="space-y-5"
        >

            @csrf


            {{-- Email --}}

            <div>

                <label
                    for="email"
                    class="block mb-2 font-bold text-slate-700 text-sm"
                >
                    البريد الإلكتروني
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="example@gmail.com"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                >

            </div>


            {{-- Password --}}

            <div>

                <label
                    for="password"
                    class="block mb-2 font-bold text-slate-700 text-sm"
                >
                    كلمة المرور
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="********"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                >

            </div>


            {{-- Login Button --}}

            <button
                type="submit"
                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl py-3 transition text-sm cursor-pointer"
            >
                تسجيل الدخول 🔐
            </button>

        </form>


        {{-- Register --}}

        <div class="text-center mt-6">

            <p class="text-gray-500 text-sm mb-2">
                ليس لديك حساب؟
            </p>

            <a
                href="{{ route('register') }}"
                class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-bold"
            >
                إنشاء حساب جديد
            </a>

        </div>


        {{-- Admin Login --}}

        <div class="border-t border-gray-200 mt-6 pt-6 text-center">

            <p class="text-gray-500 text-sm mb-2">
                هل أنت مسؤول النظام؟
            </p>

            <a
                href="{{ route('admin.login') }}"
                class="inline-block bg-amber-500 hover:bg-amber-600 text-slate-900 px-5 py-2 rounded-xl text-sm font-bold transition"
            >
                دخول الأدمن ⚡
            </a>

        </div>


    </div>

</div>


</body>
</html>