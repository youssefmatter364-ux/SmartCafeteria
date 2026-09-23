<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطلبات - كافيتريا الذكاء الاصطناعي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #F3F4F6; color: #1F2937; }
    </style>
</head>
<body class="min-h-screen pb-16">

    <!-- Header احترافي -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-xs py-4 px-6 mb-8">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center shadow-md text-lg">
                    📊
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-900">لوحة تحكم الطلبات</h1>
                    <p class="text-[11px] text-slate-400">نظام إدارة الكافيتريا الذكي</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="/menu" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                    <span>🍔</span> عرض الموقع والمنيو
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                        <span>🚪</span> تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">إدارة الحجوزات والطلبات الحالية</h2>
                <p class="text-xs text-slate-500 mt-0.5">تابع الطلبات الواردة لحظة بلحظة وقم بتأكيدها أو إلغائها.</p>
            </div>
            
            <a href="/admin/orders/all" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-md transition flex items-center gap-2">
                <span>📂</span> عرض كل السجلات والطلبات السابقة
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/80 p-16 text-center shadow-xs">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    📭
                </div>
                <p class="text-slate-800 font-extrabold text-lg">لا توجد طلبات متاحة حالياً!</p>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">سيتم عرض أي طلب جديد يتم إجراؤه من صفحة المنيو العامة هنا بشكل فوري.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-5">
                @foreach($orders as $order)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 hover:shadow-md transition flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        
                        <!-- Order Info -->
                        <div class="space-y-3 flex-1">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="bg-amber-100 text-amber-900 font-extrabold text-xs px-3.5 py-1.5 rounded-xl">
                                    طلب #{{ $order->id }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">
                                    🕒 {{ $order->created_at->diffForHumans() }} ({{ $order->created_at->format('Y-m-d h:i A') }})
                                </span>
                                <span class="text-xs font-bold px-3 py-1 rounded-xl 
                                    {{ $order->status == 'pending' ? 'bg-yellow-50 text-yellow-800 border border-yellow-200' : '' }}
                                    {{ $order->status == 'confirmed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : '' }}
                                    {{ $order->status == 'cancelled' ? 'bg-rose-50 text-rose-800 border border-rose-200' : '' }}">
                                    {{ $order->status == 'pending' ? 'قيد الانتظار ⏳' : ($order->status == 'confirmed' ? 'تم التأكيد ✅' : 'ملغي ❌') }}
                                </span>
                            </div>

                            <!-- Order Items List -->
                            <div class="flex flex-wrap gap-2">
                                @foreach($order->items as $item)
                                    <div class="bg-slate-50 border border-slate-200/60 rounded-2xl px-3.5 py-2 text-xs flex items-center gap-2.5">
                                        <span class="font-bold text-slate-800">{{ $item->item_name }}</span>
                                        <span class="text-slate-400">× {{ $item->quantity }}</span>
                                        <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-lg">({{ $item->price * $item->quantity }} ج.م)</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total & Action -->
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between md:justify-end w-full md:w-auto gap-5 border-t md:border-t-0 pt-4 md:pt-0 border-slate-100">
                            <div class="text-right">
                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">الإجمالي الكلي</p>
                                <p class="text-xl font-extrabold text-emerald-600">{{ $order->total_price }} ج.م</p>
                            </div>

                            <!-- أزرار الإجراءات -->
                            @if($order->status == 'pending')
                                <div class="flex items-center gap-2.5 w-full md:w-auto">
                                    <form action="/admin/orders/{{ $order->id }}/confirm" method="POST" class="flex-1 md:flex-initial">
                                        @csrf
                                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-3 rounded-2xl transition shadow-md shadow-emerald-600/20">
                                            تأكيد الحجز ✅
                                        </button>
                                    </form>

                                    <form action="/admin/orders/{{ $order->id }}/cancel" method="POST" class="flex-1 md:flex-initial">
                                        @csrf
                                        <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-4 py-3 rounded-2xl transition shadow-md shadow-rose-600/20">
                                            إلغاء الحجز ❌
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>