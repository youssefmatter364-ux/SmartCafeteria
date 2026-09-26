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

            <div
                class="w-20 h-20 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-5 text-4xl shadow-lg"
            >
                ⚡
            </div>

            <h1 class="text-2xl font-black text-slate-900">
                لوحة تحكم الأدمن
            </h1>

            <p class="text-sm text-slate-500 mt-2">
                تسجيل الدخول لإدارة Smart Cafeteria
            </p>

        </div>


        {{-- Error Message --}}

        @if(session('error'))

            <div
                class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm font-bold"
            >
                {{ session('error') }}
            </div>

        @endif


        {{-- Validation Errors --}}

        @if($errors->any())

            <div
                class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm"
            >

                @foreach($errors->all() as $error)

                    <div class="mb-1 last:mb-0">
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- Success Message --}}

        @if(session('success'))

            <div
                class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-5 text-sm font-bold"
            >
                {{ session('success') }}
            </div>

        @endif


        {{-- ADMIN LOGIN FORM --}}

        <form
            action="{{ route('admin.login.store') }}"
            method="POST"
            class="space-y-5"
        >

            @csrf


            {{-- Email --}}

            <div>

                <label
                    for="email"
                    class="block text-sm font-bold text-slate-700 mb-2"
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
                    autofocus
                    placeholder="admin@gmail.com"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                >

            </div>


            {{-- Password --}}

            <div>

                <label
                    for="password"
                    class="block text-sm font-bold text-slate-700 mb-2"
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
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                >

            </div>


            {{-- Login Button --}}

            <button
                type="submit"
                class="w-full bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-slate-950 font-black py-3 rounded-xl transition duration-200 cursor-pointer shadow-md"
            >
                تسجيل الدخول للأدمن 🔐
            </button>

        </form>


        {{-- Back To Customer Login --}}

        <div class="text-center mt-6">

            <a
                href="{{ route('login') }}"
                class="text-slate-500 hover:text-slate-900 text-sm font-semibold transition"
            >
                العودة لتسجيل دخول العملاء
            </a>

        </div>


        {{-- Register --}}

        <div class="text-center mt-3">

            <a
                href="{{ route('register') }}"
                class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-semibold transition"
            >
                إنشاء حساب عميل جديد
            </a>

        </div>

    </div>


    {{-- Footer --}}

    <p class="text-center text-slate-400 text-xs mt-5">
        Smart Cafeteria © {{ date('Y') }}
    </p>

</div>


</body>
</html>