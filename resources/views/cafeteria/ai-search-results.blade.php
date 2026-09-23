<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتائج البحث الذكي - AI Cafeteria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">نتائج البحث الذكي عن: "{{ $query }}"</h1>
            <a href="/menu" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-4 py-2 rounded-xl transition">العودة للمنيو 🍔</a>
        </div>

        @if($results->isEmpty())
            <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-slate-500">
                عذراً، لم نجد وجبات مطابقة لبحثك. جرب بحثاً آخر!
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($results as $item)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800">{{ $item->name }}</h3>
                            <p class="text-slate-500 text-sm mt-1">{{ $item->description }}</p>
                        </div>
                        <div class="text-left">
                            <span class="text-emerald-600 font-bold text-lg">{{ $item->price }} ج.م</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>