<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم المركزية | كافيتريا الذكاء الاصطناعي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen pb-12 selection:bg-amber-500 selection:text-slate-950">

    <!-- Navbar -->
    <nav class="bg-slate-900/85 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-amber-500 to-yellow-400 rounded-xl flex items-center justify-center text-slate-950 font-black shadow-lg shadow-amber-500/20">
                    ⚡
                </div>
                <div>
                    <h1 class="text-lg font-black text-white tracking-wide">لوحة التحكم المركزية</h1>
                    <p class="text-xs text-slate-400">كافيتريا الذكاء الاصطناعي - جامعة المنوفية</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('menu') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl transition border border-slate-700/60 flex items-center gap-2">
                    <span>🌐</span> عرض الموقع للعملاء
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white text-xs font-bold px-4 py-2.5 rounded-xl transition border border-rose-500/20 flex items-center gap-2 cursor-pointer">
                        <span>🚪</span> تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">

        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-sm font-bold flex items-center gap-3 shadow-lg">
                <span class="text-lg">✅</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-sm font-bold flex items-center gap-3 shadow-lg">
                <span class="text-lg">❌</span> {{ session('error') }}
            </div>
        @endif

        <!-- إحصائيات سريعة -->
        @isset($stats)
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-2xl text-center">
                <div class="text-2xl font-black text-amber-500">{{ $stats['pending'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">طلبات معلقة</div>
            </div>
            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-2xl text-center">
                <div class="text-2xl font-black text-emerald-500">{{ $stats['confirmed'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">طلبات مؤكدة</div>
            </div>
            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-2xl text-center">
                <div class="text-2xl font-black text-rose-500">{{ $stats['cancelled'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">طلبات ملغية</div>
            </div>
            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-2xl text-center">
                <div class="text-2xl font-black text-blue-500">{{ $stats['food'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">الوجبات</div>
            </div>
            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-2xl text-center">
                <div class="text-2xl font-black text-purple-500">{{ $stats['beverages'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">المشروبات</div>
            </div>
            <div class="bg-slate-900/60 border border-slate-800 p-4 rounded-2xl text-center">
                <div class="text-2xl font-black text-yellow-500">{{ $stats['categories'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">التصنيفات</div>
            </div>
        </div>
        @endisset

        <!-- قسم إضافة تصنيف جديد وإدارة المنيو -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- إضافة تصنيف -->
            <div class="bg-slate-900/65 backdrop-blur-xl border border-slate-800 p-6 sm:p-8 rounded-3xl shadow-2xl">
                <div class="mb-4">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-amber-500">📁</span> إدارة التصنيفات
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">أضف تصنيفاً جديداً لتنظيم المنتجات.</p>
                </div>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2">اسم التصنيف</label>
                        <input type="text" name="name" required placeholder="مثال: وجبات سريعة" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2">نوع التصنيف</label>
                        <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                            <option value="food">طعام (Food)</option>
                            <option value="beverage">مشروب (Beverage)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 text-white font-bold py-3 rounded-xl transition border border-slate-700 cursor-pointer text-sm">
                        إضافة التصنيف 📁
                    </button>
                </form>
            </div>

            <!-- إضافة منتج جديد -->
            <div class="bg-slate-900/65 backdrop-blur-xl border border-slate-800 p-6 sm:p-8 rounded-3xl shadow-2xl">
                <div class="mb-4">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-amber-500">🍔</span> إضافة منتج للمنيو
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">أضف أطعمة ومشروبات لتظهر للعملاء.</p>
                </div>

                <form action="{{ route('admin.menu.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">اسم المنتج</label>
                            <input type="text" name="name" required placeholder="برجر دجاج" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">السعر (ج.م)</label>
                            <input type="number" step="0.5" name="price" required placeholder="50" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">التصنيف</label>
                            <select name="category_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                                <option value="">اختر التصنيف...</option>
                                @php
                                    $catArray = isset($categories) ? collect($categories)->values()->all() : [];
                                    $catCount = count($catArray);
                                @endphp
                                @for($i = 0; $i < $catCount; $i++)
                                    <option value="{{ $catArray[$i]->id }}">{{ $catArray[$i]->name }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">النوع</label>
                            <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition">
                                <option value="food">طعام</option>
                                <option value="beverage">مشروب</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-black py-3 rounded-xl transition shadow-lg shadow-amber-500/20 cursor-pointer text-sm">
                        ➕ إضافة للمنيو
                    </button>
                </form>
            </div>

        </div>

        <!-- Orders Management Section -->
        <div class="bg-slate-900/65 backdrop-blur-xl border border-slate-800 p-6 sm:p-8 rounded-3xl shadow-2xl">
            <div class="mb-6">
                <h2 class="text-lg font-black text-white flex items-center gap-2">
                    <span class="text-amber-500">📦</span> متابعة الطلبات الواردة
                </h2>
                <p class="text-xs text-slate-400 mt-1">إدارة وحالة طلبات العملاء اللحظية.</p>
            </div>

            <div class="space-y-4">
                @php
                    $orderArray = isset($orders) ? collect($orders)->values()->all() : [];
                    $orderCount = count($orderArray);
                @endphp

                @if($orderCount > 0)
                    @for($j = 0; $j < $orderCount; $j++)
                        @php
                            $order = $orderArray[$j];
                            $st =$order->status ?? 'pending';
                            $statusClass =$st == 'confirmed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($st == 'cancelled' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20');$statusText = $st == 'confirmed' ? 'تم التأكيد ✅' : ($st == 'cancelled' ? 'ملغي ❌' : 'قيد الانتظار ⏳');
                            $userName =$order->user->name ?? 'زائر';
                            $orderDate = isset($order->created_at) ?$order->created_at->format('Y-m-d H:i') : '';
                        @endphp
                        <div class="p-5 rounded-2xl border border-slate-800 bg-slate-950/60 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 transition hover:border-slate-700">
                            <div class="space-y-1">
                                <div class="flex items-center gap-3">
                                    <span class="font-black text-white text-base">طلب #{{ $order->id ?? 0 }}</span>
                                    <span class="text-xs px-3 py-1 rounded-full font-bold {{ $statusClass }}">{{ $statusText }}</span>
                                </div>
                                <p class="text-xs text-slate-400">العميل: <span class="text-slate-200 font-semibold">{{ $userName }}</span> | وقت الطلب: <span class="text-slate-300">{{ $orderDate }}</span></p>
                            </div>

                            <div class="flex items-center gap-2 w-full lg:w-auto justify-end">
                                @if($st == 'pending')
                                    <form action="{{ route('admin.orders.confirm', $order->id ?? 0) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-md cursor-pointer">تأكيد الطلب</button>
                                    </form>
                                    <form action="{{ route('admin.orders.cancel', $order->id ?? 0) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-rose-600 hover:bg-rose-500 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-md cursor-pointer">إلغاء</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-500 font-semibold">تم الحسم</span>
                                @endif
                            </div>
                        </div>
                    @endfor
                @else
                    <div class="text-center py-16 bg-slate-950/40 rounded-2xl border border-dashed border-slate-800">
                        <div class="text-4xl mb-2">📭</div>
                        <p class="text-slate-400 text-sm font-semibold">لا توجد طلبات جديدة معلقة حالياً.</p>
                    </div>
                @endif
            </div>
        </div>

    </main>

    <!-- نظام المساعد الذكي (Chatbot Widget) للأدمن -->
    <div id="chatbot-container" class="fixed bottom-6 left-6 z-50 font-sans">
        <button id="chatbot-toggle-btn" class="w-14 h-14 bg-amber-500 hover:bg-amber-400 text-slate-950 rounded-full flex items-center justify-center shadow-2xl shadow-amber-500/40 text-2xl font-black transition transform hover:scale-105 cursor-pointer">
            🤖
        </button>

        <div id="chatbot-window" class="hidden absolute bottom-20 left-0 w-80 sm:w-96 bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden flex flex-col h-[450px]">
            <div class="bg-slate-950 px-5 py-4 border-b border-slate-800 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                    <div>
                        <h3 class="text-sm font-black text-white">مساعد الأدمن الذكي</h3>
                        <p class="text-[10px] text-slate-400">اسألني عن المنيو أو مين مسجل دخول</p>
                    </div>
                </div>
                <button id="chatbot-close-btn" class="text-slate-400 hover:text-white text-lg font-bold cursor-pointer">✕</button>
            </div>

            <div id="chatbot-messages" class="flex-1 p-4 overflow-y-auto space-y-3 text-xs">
                <div class="flex items-start gap-2">
                    <div class="w-7 h-7 bg-amber-500 rounded-full flex items-center justify-center text-slate-950 font-black shrink-0">🤖</div>
                    <div class="bg-slate-800 text-slate-200 p-3 rounded-2xl rounded-tr-none max-w-[80%] leading-relaxed">
                        أهلاً يا بشمهندس يوسف! أنا معاك هنا في لوحة التحكم. اسألني عن أي حاجة، أو اكتب: <span class="text-amber-400 font-bold">"مين سجل دخول؟"</span> وهجيبلك الحالة فوراً.
                    </div>
                </div>
            </div>

            <div class="p-3 bg-slate-950 border-t border-slate-800 flex items-center gap-2">
                <input type="text" id="chatbot-input" placeholder="اكتب سؤالك هنا..." class="flex-1 bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                <button id="chatbot-send-btn" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl transition cursor-pointer text-xs">إرسال</button>
            </div>
        </div>
    </div>

    <!-- JavaScript الخاص بالشات بوت -->
    <script>
        const toggleBtn = document.getElementById('chatbot-toggle-btn');
        const closeBtn = document.getElementById('chatbot-close-btn');
        const windowBox = document.getElementById('chatbot-window');
        const sendBtn = document.getElementById('chatbot-send-btn');
        const inputField = document.getElementById('chatbot-input');
        const messagesBox = document.getElementById('chatbot-messages');

        toggleBtn.addEventListener('click', () => windowBox.classList.toggle('hidden'));
        closeBtn.addEventListener('click', () => windowBox.classList.add('hidden'));

        sendBtn.addEventListener('click', sendMessage);
        inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        function sendMessage() {
            const text = inputField.value.trim();
            if (!text) return;

            appendMessage(text, 'user');
            inputField.value = '';

            fetch("{{ route('chatbot.respond') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: text })
            })
            .then(res => res.json())
            .then(data => {
                appendMessage(data.reply, 'bot');
            })
            .catch(err => {
                appendMessage('عذراً، حدث خطأ في الاتصال بالمساعد الذكي.', 'bot');
            });
        }

        function appendMessage(text, sender) {
            const div = document.createElement('div');
            if (sender === 'user') {
                div.className = 'flex items-end justify-end gap-2';
                div.innerHTML = `<div class="bg-amber-500 text-slate-950 p-3 rounded-2xl rounded-tl-none max-w-[80%] leading-relaxed font-semibold">${text}</div>`;
            } else {
                div.className = 'flex items-start gap-2';
                div.innerHTML = `<div class="w-7 h-7 bg-amber-500 rounded-full flex items-center justify-center text-slate-950 font-black shrink-0">🤖</div>
                                 <div class="bg-slate-800 text-slate-200 p-3 rounded-2xl rounded-tr-none max-w-[80%] leading-relaxed whitespace-pre-line">${text}</div>`;
            }
            messagesBox.appendChild(div);
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }
    </script>

</body>
</html>