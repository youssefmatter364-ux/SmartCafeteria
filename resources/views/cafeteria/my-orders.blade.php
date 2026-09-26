<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>طلباتي</title>

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

<body class="bg-slate-100 min-h-screen">

<header class="bg-slate-900 text-white p-5">

    <div class="max-w-5xl mx-auto flex justify-between items-center">

        <h1 class="text-xl font-bold">
            طلباتي 📦
        </h1>

        <a
            href="{{ route('menu') }}"
            class="bg-white text-slate-900 px-4 py-2 rounded-xl"
        >
            العودة للمنيو
        </a>

    </div>

</header>


<main class="max-w-5xl mx-auto p-6">

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded-xl mb-5">
            {{ session('error') }}
        </div>
    @endif


    @forelse($orders as $order)

        <div class="bg-white rounded-2xl shadow p-6 mb-5">

            <div class="flex justify-between items-center mb-5">

                <div>
                    <h2 class="font-bold text-lg">
                        طلب #{{ $order->id }}
                    </h2>

                    <p class="text-gray-500 text-sm">
                        {{ $order->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>


                @if($order->status === 'pending')

                    <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-xl">
                        في انتظار الإدارة ⏳
                    </span>

                @elseif($order->status === 'confirmed')

                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-xl">
                        تم قبول الطلب ✅
                    </span>

                @else

                    <span class="bg-red-100 text-red-800 px-4 py-2 rounded-xl">
                        تم رفض الطلب ❌
                    </span>

                @endif

            </div>


            <div class="space-y-2">

                @foreach($order->items as $item)

                    <div class="flex justify-between border-b py-2">

                        <span>
                            {{ $item->product->name ?? 'منتج محذوف' }}
                            × {{ $item->quantity }}
                        </span>

                        <span class="font-bold">
                            {{ $item->subtotal }} جنيه
                        </span>

                    </div>

                @endforeach

            </div>


            <div class="flex justify-between items-center mt-5">

                <strong>
                    الإجمالي:
                    {{ $order->total_price }}
                    جنيه
                </strong>


                @if($order->status === 'pending')

                    <form
                        action="{{ route('order.customer.cancel', $order->id) }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            onclick="return confirm('هل تريد إلغاء الطلب؟')"
                            class="bg-red-500 text-white px-4 py-2 rounded-xl"
                        >
                            إلغاء الطلب
                        </button>

                    </form>

                @endif

            </div>

        </div>

    @empty

        <div class="bg-white rounded-2xl p-10 text-center">
            <p class="text-gray-500">
                لم تقم بعمل أي طلبات حتى الآن.
            </p>

            <a
                href="{{ route('menu') }}"
                class="inline-block mt-5 bg-slate-900 text-white px-5 py-3 rounded-xl"
            >
                اذهب للمنيو
            </a>
        </div>

    @endforelse

</main>

</body>
</html>