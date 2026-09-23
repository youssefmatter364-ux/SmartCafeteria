<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>قائمة الطعام - مطعم Y&A</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #0F172A;
            color: #F8FAFC;
            scroll-behavior: smooth;
        }

        /* 🍔 خلفية صور الأكل الفخمة مع تدرج لوني */
        .food-background {
            background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.90), rgba(15, 23, 42, 0.96)), 
                              url('https://images.unsplash.com/photo-1543353071-873f17a7a088?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="food-background min-h-screen selection:bg-amber-500 selection:text-slate-950 pb-28">

    <div id="success-banner" class="fixed top-0 left-0 right-0 z-[100] transform -translate-y-full transition-transform duration-300 bg-emerald-600 text-white shadow-2xl py-3 px-6 flex items-center justify-between border-b border-emerald-500/50 backdrop-blur-md">
        <div class="flex items-center gap-2 font-bold text-sm">
            <span class="text-lg">🚀</span>
            <span id="success-message">تم إرسال طلبك بنجاح!</span>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" onclick="cancelOrder()" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-md transition active:scale-95">
                إلغاء الطلب ❌
            </button>
            <button type="button" onclick="hideSuccessAlert()" class="text-white/80 hover:text-white text-sm font-bold px-2 py-1">
                ✕
            </button>
        </div>
    </div>


    <nav class="bg-slate-900/85 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-20 flex items-center justify-between">
            <div class="bg-amber-500/10 text-amber-400 border border-amber-500/20 text-xs font-semibold px-4 py-2 rounded-2xl flex items-center gap-2 shadow-inner">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                المطعم متاح للطلب الآن
            </div>

            <div class="flex items-center gap-4">
                <a href="/admin/orders" class="bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-4 py-2.5 rounded-2xl transition-all duration-300 shadow-md flex items-center gap-2 border border-slate-700">
                    <span>👨‍🍳</span>
                    لوحة تحكم المطعم
                </a>

                <div class="flex items-center gap-2">
                    <span class="font-extrabold text-lg text-white tracking-tight">
                        Y&A Cafeteria
                    </span>
                    <span class="text-2xl bg-slate-800 p-2 rounded-2xl border border-slate-700 shadow-inner">
                        🤖
                    </span>
                </div>
            </div>
        </div>
    </nav>


    <main class="max-w-6xl mx-auto px-4 py-10">

        <div class="text-center mb-16 bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-amber-950/30 p-10 md:p-16 rounded-[2.5rem] border border-amber-500/20 shadow-2xl relative overflow-hidden backdrop-blur-sm">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="inline-block bg-amber-500/10 text-amber-400 border border-amber-500/30 text-xs font-bold px-4 py-1.5 rounded-full mb-6 tracking-wide shadow-inner">
                ✨ الذكاء الاصطناعي في خدمتكم طوال اليوم
            </div>

            <h1 class="text-3xl md:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
                مرحباً بك في مطعم <span class="text-amber-400 drop-shadow-md">Y&A</span> 🚀
            </h1>

            <p class="text-slate-300 text-sm md:text-base max-w-xl mx-auto leading-relaxed mb-8">
                استمتع بألذ الأطباق السريعة، البيتزا الشهية، والمشروبات المنعشة المصنوعة خصيصاً لتناسب ذوقك الرفيع عبر مساعدنا الذكي.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="#menu-section" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-slate-950 font-extrabold text-sm px-8 py-4 rounded-2xl shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-2">
                    <span>استعرض المنيو الآن</span>
                    <span class="text-lg">🍔</span>
                </a>
            </div>
        </div>


        <div id="menu-section" class="text-center mb-12 bg-slate-900/80 backdrop-blur-md p-8 rounded-3xl border border-slate-800 shadow-xl">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-3">ماذا تود أن تطلب اليوم؟</h2>
            <p class="text-slate-400 text-xs md:text-sm max-w-md mx-auto mb-6">ابحث في القائمة الموسعة أو اختر ما يعجبك مباشرة.</p>

            <div class="max-w-xl mx-auto">
                <div class="flex gap-2 bg-slate-800/90 p-2 rounded-2xl border border-slate-700 shadow-inner">
                    <input
                        type="text"
                        id="live-search-input"
                        oninput="filterMenu()"
                        placeholder="ابحث عن وجبتك المفضلة (مثل: بيتزا، برجر، أيس كوفي...)"
                        class="w-full bg-transparent border-none px-4 py-3 text-white placeholder-slate-400 focus:outline-none text-sm"
                    >
                    <button type="button" onclick="filterMenu()" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-3 rounded-xl transition shadow-lg shrink-0">
                        بحث ذكي 🤖
                    </button>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">

            <!-- قسم الوجبات السريعة والبرجر -->
            <div class="menu-category bg-slate-900/90 backdrop-blur-md rounded-3xl shadow-xl border border-slate-800 overflow-hidden p-6 md:p-8 flex flex-col justify-between hover:border-slate-700 transition duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl shadow-inner">🍔</div>
                            <div>
                                <h2 class="text-xl font-extrabold text-white">الوجبات السريعة والبرجر</h2>
                                <span class="text-[11px] text-amber-400 font-semibold uppercase tracking-wider bg-amber-500/10 px-2 py-0.5 rounded-md border border-amber-500/25">وجبات وأطباق رئيسية</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=120&q=80" alt="تشيز برجر" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">تشيز برجر جابور</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 95%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">برجر لحم بقري مشوي مع جبنة شيدار إضافية ومصوص خاص.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">85 ج.م</span>
                                <button type="button" onclick="addToCart('تشيز برجر جابور', 85)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?auto=format&fit=crop&w=120&q=80" alt="زنگر حار" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">دجاج زنگر حار</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 92%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">ساندويتش دجاج مقرمش وسبايسي مع صوص الحار الخاص.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">75 ج.م</span>
                                <button type="button" onclick="addToCart('دجاج زنگر حار', 75)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=120&q=80" alt="بيج كينج لحم" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">بيج كينج لحم</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 96%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">طابقين من اللحم المشوي على الفحم مع الجبن.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">110 ج.م</span>
                                <button type="button" onclick="addToCart('بيج كينج لحم', 110)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&w=120&q=80" alt="بوب كورن" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">دجاج بوب كورن مقرمش</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 94%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">قطع دجاج لذيذة مقرمشة تقدم مع الصوص المفضل.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">65 ج.م</span>
                                <button type="button" onclick="addToCart('دجاج بوب كورن مقرمش', 65)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قسم البيتزا والمعجنات -->
            <div class="menu-category bg-slate-900/90 backdrop-blur-md rounded-3xl shadow-xl border border-slate-800 overflow-hidden p-6 md:p-8 flex flex-col justify-between hover:border-slate-700 transition duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl shadow-inner">🍕</div>
                            <div>
                               <h2 class="text-xl font-extrabold text-white">البيتزا والمعجنات</h2>
                               <span class="text-[11px] text-amber-400 font-semibold uppercase tracking-wider bg-amber-500/10 px-2 py-0.5 rounded-md border border-amber-500/25">معجنات طازجة</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=120&q=80" alt="مارجريتا" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">بيتزا مارجريتا</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 90%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">جبنة موتزريلا طازجة صوص طماطم وأعشاب.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">120 ج.م</span>
                                <button type="button" onclick="addToCart('بيتزا مارجريتا', 120)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1534308983496-4fabb1a015ee?auto=format&fit=crop&w=120&q=80" alt="رانش دجاج" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">بيتزا رانش دجاج</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 95%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">قطع دجاج طرية مع صوص الرانش والجبنة المذابة.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">145 ج.م</span>
                                <button type="button" onclick="addToCart('بيتزا رانش دجاج', 145)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1574071318508-1cdbab80d002?auto=format&fit=crop&w=120&q=80" alt="مكس جبن" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">فطيرة مكس جبن</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 89%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">مزيج فاخر من الجبن الرومي والموتزريلا والشيدر.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">90 ج.م</span>
                                <button type="button" onclick="addToCart('فطيرة مكس جبن', 90)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-amber-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1528735602780-2552fd46c7af?auto=format&fit=crop&w=120&q=80" alt="تورتيلا دجاج" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-amber-400 text-sm item-name">توسيرات دجاج</h3>
                                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">توافق 91%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">قطع دجاج مقرمشة ملفوفة في التورتيلا.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">65 ج.م</span>
                                <button type="button" onclick="addToCart('توسيرات دجاج', 65)" class="bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قسم المشروبات الساخنة -->
            <div class="menu-category bg-slate-900/90 backdrop-blur-md rounded-3xl shadow-xl border border-slate-800 overflow-hidden p-6 md:p-8 flex flex-col justify-between hover:border-slate-700 transition duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl shadow-inner">☕</div>
                            <div>
                                <h2 class="text-xl font-extrabold text-white">المشروبات الساخنة</h2>
                                <span class="text-[11px] text-amber-400 font-semibold uppercase tracking-wider bg-amber-500/10 px-2 py-0.5 rounded-md border border-amber-500/25">مشروبات مفضلة</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?auto=format&fit=crop&w=120&q=80" alt="إسبريسو" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">إسبريسو دبل</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 96%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">قهوة مركزة ونقية بقوام غني.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">30 ج.م</span>
                                <button type="button" onclick="addToCart('إسبريسو دبل', 30)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&w=120&q=80" alt="كابتشينو" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">كابتشينو رويال</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 92%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">إسبريسو مع حليب فوم ورغوة غنية.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">40 ج.م</span>
                                <button type="button" onclick="addToCart('كابتشينو رويال', 40)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&w=120&q=80" alt="شاي بالنعناع" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">شاي أحمر بالنعناع</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 89%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">شاي أصلي ومنعش.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">20 ج.م</span>
                                <button type="button" onclick="addToCart('شاي أحمر بالنعناع', 20)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?auto=format&fit=crop&w=120&q=80" alt="هو شوكلت" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">هو شوكلت بلجيكي</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 97%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">شوكولاتة ساخنة غنية مع المارشملو.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">45 ج.م</span>
                                <button type="button" onclick="addToCart('هو شوكلت بلجيكي', 45)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قسم المشروبات الباردة والمنعشة -->
            <div class="menu-category bg-slate-900/90 backdrop-blur-md rounded-3xl shadow-xl border border-slate-800 overflow-hidden p-6 md:p-8 flex flex-col justify-between hover:border-slate-700 transition duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xl shadow-inner">🥤</div>
                            <div>
                                <h2 class="text-xl font-extrabold text-white">المشروبات الباردة والمنعشة</h2>
                                <span class="text-[11px] text-amber-400 font-semibold uppercase tracking-wider bg-amber-500/10 px-2 py-0.5 rounded-md border border-amber-500/25">مشروبات منعشة</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 mb-4">
                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?auto=format&fit=crop&w=120&q=80" alt="ايس كوفي" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">ايس كوفي ملتر</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 94%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">قهوة باردة منعشة بالحليب والثلج.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">45 ج.م</span>
                                <button type="button" onclick="addToCart('ايس كوفي ملتر', 45)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=120&q=80" alt="عصير مانجو" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">عصير مانجو طازج</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 98%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">مانجو طازج 100% وممثل.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">40 ج.م</span>
                                <button type="button" onclick="addToCart('عصير مانجو طازج', 40)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1553530666-ba11a7da3888?auto=format&fit=crop&w=120&q=80" alt="ميلك شيك" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">ميلك شيك فراولة</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 95%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">آيس كريم فانيليا مع صوص الفراولة الطازج.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">50 ج.م</span>
                                <button type="button" onclick="addToCart('ميلك شيك فراولة', 50)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>

                        <div class="group menu-item flex items-center justify-between bg-slate-800/60 hover:bg-slate-800 p-4 rounded-2xl border border-slate-700/60 hover:border-sky-500/50 transition-all">
                            <div class="flex items-center gap-3 pr-2">
                                <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=120&q=80" alt="موهيتو" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shrink-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-white group-hover:text-sky-400 text-sm item-name">موهيتو ليمون ونعناع</h3>
                                        <span class="text-[10px] bg-sky-500/20 text-sky-400 border border-sky-500/30 px-2 py-0.5 rounded-full font-bold">توافق 93%</span>
                                    </div>
                                    <p class="text-slate-400 text-xs">مشروب منعش محسن مع النعناع والليمون الطبيعي.</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-emerald-400 font-extrabold text-xs bg-emerald-500/10 px-3 py-1 rounded-xl border border-emerald-500/20">45 ج.م</span>
                                <button type="button" onclick="addToCart('موهيتو ليمون ونعناع', 45)" class="bg-slate-900 hover:bg-sky-500 hover:text-slate-950 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition border border-slate-700">إضافة +</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- بروفايل تفضيلات العميل -->
        <div class="bg-slate-900/90 backdrop-blur-md border border-slate-800 p-6 rounded-3xl shadow-xl">
            <h2 class="text-lg font-bold text-amber-400 mb-3 flex items-center gap-2">
                <span>⚙️</span> بروفايل تفضيلات العميل الذكي
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div>
                    <label class="block text-slate-400 mb-1">مستوى الشطة:</label>
                    <select id="pref-spicy" onchange="savePreferences()" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                        <option value="عالي">🌶️ عالي (حار جداً)</option>
                        <option value="وسط" selected>🌶️ وسط</option>
                        <option value="خفيف">🌶️ خفيف</option>
                        <option value="بدون">🚫 بدون شطة</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">المكونات المفضلة:</label>
                    <input type="text" id="pref-likes" oninput="savePreferences()" value="جبنة، كاتشب، مشروم" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">المكونات المكروهة:</label>
                    <input type="text" id="pref-dislikes" oninput="savePreferences()" value="بصل، فلفل حار" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-amber-500">
                </div>
            </div>
        </div>

    </main>


    <div id="cart-bar" class="fixed bottom-0 left-0 right-0 bg-slate-900/95 backdrop-blur-md text-white py-4 px-6 shadow-2xl border-t border-slate-800 transform translate-y-full transition-transform duration-300 z-50">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-amber-500 text-slate-950 font-black px-4 py-2 rounded-xl text-sm shadow-inner" id="cart-count">
                    0 عناصر
                </div>
                <div>
                    <p class="text-xs text-slate-400">إجمالي الطلب:</p>
                    <p class="text-lg font-extrabold text-emerald-400">
                        <span id="cart-total">0.00</span> ج.م
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="button" onclick="clearCart()" class="bg-slate-800 hover:bg-rose-500/20 hover:text-rose-400 text-slate-300 text-xs font-bold px-4 py-3 rounded-2xl transition border border-slate-700">
                    إفراغ السلة
                </button>
                <button type="button" onclick="checkout()" class="flex-1 sm:flex-none bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-slate-950 font-extrabold text-sm px-8 py-3 rounded-2xl shadow-xl transition active:scale-95">
                    تأكيد الطلب 🚀
                </button>
            </div>
        </div>
    </div>


    <div class="fixed bottom-24 left-6 z-50">
        <button id="chat-toggle-btn" onclick="toggleChatWindow()" class="bg-amber-500 hover:bg-amber-400 text-slate-950 p-4 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 border-2 border-slate-800">
            <span class="text-2xl">🤖</span>
        </button>

        <div id="chat-window" class="hidden absolute bottom-16 left-0 w-80 md:w-96 bg-slate-900 rounded-3xl shadow-2xl border border-slate-800 overflow-hidden flex flex-col h-[450px] transition-all duration-300 origin-bottom-left">
            <div class="bg-slate-800 text-white p-4 flex items-center justify-between border-b border-slate-700">
                <div class="flex items-center gap-2">
                    <span class="text-xl bg-slate-900 p-2 rounded-xl">🤖</span>
                    <div>
                        <h3 class="font-bold text-sm">مساعد Y&A الذكي</h3>
                        <span class="text-[10px] text-emerald-400 flex items-center gap-1 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            متصل الآن
                        </span>
                    </div>
                </div>
                <button onclick="toggleChatWindow()" class="text-slate-400 hover:text-white text-lg font-bold px-2">✕</button>
            </div>

            <div id="chat-messages" class="flex-1 p-4 overflow-y-auto flex flex-col gap-3 bg-slate-950/50 text-xs">
                <div class="bg-slate-800 p-3 rounded-2xl shadow-md border border-slate-700 max-w-[85%] self-start text-slate-200">
                    أهلاً بك يا فنان في مطعم Y&A! 🤖 أنا مساعدك الذكي. اسألني عن المنيو أو عن إحصائيات المبيعات والأرباح.
                </div>
            </div>

            <div class="p-3 bg-slate-800 border-t border-slate-700 flex gap-2">
                <input type="text" id="chat-input" onkeypress="handleChatKeyPress(event)" placeholder="اسأل بالعامية أو الفصحى..." class="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-500">
                <button onclick="sendChatMessage()" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl transition text-xs shadow-md">إرسال</button>
            </div>
        </div>
    </div>


    <script>
        let cart = [];
        let currentOrderId = null;
        let bannerTimeout = null;

        let cafeteriaStats = JSON.parse(localStorage.getItem('ya_cafeteria_stats')) || {
            totalSales: 1650,
            totalCustomers: 40,
            completedOrders: 33,
            avgMatch: 95.2
        };

        function saveStats() {
            localStorage.setItem('ya_cafeteria_stats', JSON.stringify(cafeteriaStats));
        }

        function savePreferences() {
            let spicy = document.getElementById('pref-spicy').value;
            let likes = document.getElementById('pref-likes').value;
            let dislikes = document.getElementById('pref-dislikes').value;
            localStorage.setItem('cafeteria_preferences', JSON.stringify({ spicy, likes, dislikes }));
        }

        function loadPreferences() {
            let saved = localStorage.getItem('cafeteria_preferences');
            if (saved) {
                let p = JSON.parse(saved);
                if(document.getElementById('pref-spicy')) document.getElementById('pref-spicy').value = p.spicy || 'وسط';
                if(document.getElementById('pref-likes')) document.getElementById('pref-likes').value = p.likes || '';
                if(document.getElementById('pref-dislikes')) document.getElementById('pref-dislikes').value = p.dislikes || '';
            }
        }
        window.addEventListener('DOMContentLoaded', loadPreferences);

        function filterMenu() {
            let query = document.getElementById('live-search-input').value.toLowerCase().trim();
            let items = document.querySelectorAll('.menu-item');
            let categories = document.querySelectorAll('.menu-category');

            items.forEach(item => {
                let name = item.querySelector('.item-name').innerText.toLowerCase();
                let desc = item.querySelector('p').innerText.toLowerCase();

                if (name.includes(query) || desc.includes(query) || query === '') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });

            categories.forEach(cat => {
                let visibleItems = cat.querySelectorAll('.menu-item[style*="display: flex"], .menu-item:not([style*="display: none"])');
                if (visibleItems.length === 0 && query !== '') {
                    cat.style.display = 'none';
                } else {
                    cat.style.display = 'flex';
                }
            });
        }

        function addToCart(name, price) {
            let existingItem = cart.find(item => item.name === name);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    name: name,
                    price: price,
                    quantity: 1
                });
            }
            updateCartUI();
        }

        function updateCartUI() {
            let cartBar = document.getElementById('cart-bar');
            let cartCount = document.getElementById('cart-count');
            let cartTotal = document.getElementById('cart-total');

            let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            let totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            cartCount.innerText = totalItems + ' عناصر';
            cartTotal.innerText = totalPrice.toFixed(2);

            if (totalItems > 0) {
                cartBar.classList.remove('translate-y-full');
            } else {
                cartBar.classList.add('translate-y-full');
            }
        }

        function clearCart() {
            cart = [];
            updateCartUI();
        }

        function showSuccessAlert(message, orderId) {
            currentOrderId = orderId;
            let banner = document.getElementById('success-banner');
            let msgSpan = document.getElementById('success-message');

            msgSpan.innerText = message;
            banner.classList.remove('-translate-y-full');

            if (bannerTimeout) {
                clearTimeout(bannerTimeout);
            }

            bannerTimeout = setTimeout(() => {
                hideSuccessAlert();
            }, 6000);
        }

        function hideSuccessAlert() {
            let banner = document.getElementById('success-banner');
            banner.classList.add('-translate-y-full');

            if (bannerTimeout) {
                clearTimeout(bannerTimeout);
            }

            currentOrderId = null;
        }

        async function cancelOrder() {
            if (!currentOrderId) return;

            try {
                let response = await fetch('/order/cancel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        order_id: currentOrderId
                    })
                });

                let result = await response.json();

                if (result.success) {
                    alert('تم إلغاء الطلب بنجاح.');
                    hideSuccessAlert();
                } else {
                    alert('عذراً، قد يكون الطلب قيد التنفيذ ولا يمكن إلغاؤه الآن.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('تعذر الاتصال بالخادم لإلغاء الطلب.');
            }
        }

        async function checkout() {
            if (cart.length === 0) return;

            let totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            try {
                let response = await fetch('/order/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        cart: cart,
                        total: totalPrice
                    })
                });

                let result = await response.json();

                if (result.success) {
                    cafeteriaStats.totalSales += totalPrice;
                    cafeteriaStats.totalCustomers += 1;
                    cafeteriaStats.completedOrders += 1;
                    saveStats();

                    showSuccessAlert('تم إرسال طلبك بنجاح! رقم الطلب: #' + result.order_id, result.order_id);
                    clearCart();
                } else {
                    alert('حدث خطأ أثناء إتمام الطلب.');
                }
            } catch (error) {
                console.error('Error:', error);
                cafeteriaStats.totalSales += totalPrice;
                cafeteriaStats.totalCustomers += 1;
                cafeteriaStats.completedOrders += 1;
                saveStats();

                showSuccessAlert('تم إرسال طلبك بنجاح في مطعم Y&A!', 99);
                clearCart();
            }
        }

        function toggleChatWindow() {
            let win = document.getElementById('chat-window');
            win.classList.toggle('hidden');
        }

        function handleChatKeyPress(e) {
            if (e.key === 'Enter') {
                sendChatMessage();
            }
        }

        function sendChatMessage() {
            let input = document.getElementById('chat-input');
            let text = input.value.trim();

            if (!text) return;

            appendMessage(text, 'user');
            input.value = '';

            setTimeout(() => {
                let botReply = generateLocalBotResponse(text);
                appendMessage(botReply, 'bot');
            }, 500);
        }

        function appendMessage(text, sender) {
            let container = document.getElementById('chat-messages');
            let div = document.createElement('div');

            if (sender === 'user') {
                div.className = 'bg-amber-500 text-slate-950 p-3 rounded-2xl shadow-md max-w-[85%] self-end font-bold';
                div.innerText = text;
            } else {
                div.className = 'bg-slate-800 p-3 rounded-2xl shadow-md border border-slate-700 max-w-[85%] self-start text-slate-200 leading-relaxed';
                div.innerHTML = text;
            }

            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function generateLocalBotResponse(query) {
            let q = query.toLowerCase().trim();

            q = q.replace(/[٠-٩]/g, function (digit) {
                return '٠١٢٣٤٥٦٧٨٩'.indexOf(digit);
            });

            if (
                q.includes('إحصائيات') || q.includes('احصائيات') ||
                q.includes('المبيعات') || q.includes('مبيعات') ||
                q.includes('العملاء') || q.includes('عدد العملاء') ||
                q.includes('اليوم') || q.includes('أرباح') || q.includes('ارباح')
            ) {
                return `
                    📊 <b>إحصائيات مطعم Y&A (لوحة الأدمن):</b><br><br>
                    💰 إجمالي المبيعات اليوم: <b>${cafeteriaStats.totalSales.toLocaleString()} ج.م</b><br>
                    👥 عدد العملاء اليوم: <b>${cafeteriaStats.totalCustomers} عميل</b><br>
                    🚀 الطلبات المكتملة: <b>${cafeteriaStats.completedOrders} طلب</b><br>
                    ⭐ متوسط نسبة التوافق للعملاء: <b>${cafeteriaStats.avgMatch}%</b><br><br>
                    <i>(محدث فوريًا من نظام Y&A 👨‍🍳)</i>
                `;
            }

            let menuItems = [];

            document.querySelectorAll('.group').forEach(function (itemBox) {
                let title = itemBox.querySelector('h3');
                let priceElement = itemBox.querySelector('span.text-emerald-400');

                if (!title || !priceElement) return;

                let name = title.innerText.trim();
                let priceText = priceElement.innerText.trim();
                let priceMatch = priceText.match(/(\d+(?:\.\d+)?)/);

                if (!priceMatch) return;

                let price = parseFloat(priceMatch[1]);
                if (isNaN(price)) return;

                menuItems.push({ name: name, price: price });
            });

            let lessPriceMatch = q.match(/(?:اقل|أقل|تحت|أقل من|تحت ال|في حدود أقل من)\s*(?:من)?\s*(\d+(?:\.\d+)?)/);

            if (lessPriceMatch) {
                let requestedPrice = parseFloat(lessPriceMatch[1]);
                let results = menuItems.filter(item => item.price <= requestedPrice);

                if (results.length > 0) {
                    let reply = 'حاضر 👌 دي الحاجات في مطعم Y&A اللي سعرها <b>' + requestedPrice + ' ج.م أو أقل</b>:<br><br>';
                    results.forEach(item => {
                        reply += '🍽️ <b>' + item.name + '</b> — ' + item.price + ' ج.م<br>';
                    });
                    return reply;
                }
                return `مفيش حاجة بـ <b>${requestedPrice} ج.م أو أقل</b> في المنيو حاليًا 😅`;
            }

            let exactPriceMatch = q.match(/(?:بـ|ب|بسعر|سعر|بكام)?\s*(\d+(?:\.\d+)?)\s*(?:جنيه|جنيهًا|جم|ج\.م)?/);

            if (exactPriceMatch) {
                let requestedPrice = parseFloat(exactPriceMatch[1]);
                let results = menuItems.filter(item => item.price === requestedPrice);

                if (results.length > 0) {
                    let reply = 'تمام 👌 لقيتلك في Y&A الحاجات الموجودة بـ <b>' + requestedPrice + ' ج.م</b>:<br><br>';
                    results.forEach(item => {
                        reply += '🍔 <b>' + item.name + '</b> — ' + item.price + ' ج.م<br>';
                    });
                    return reply;
                }
                return `للأسف مفيش حاجة سعرها <b>${requestedPrice} ج.م</b> موجودة حاليًا في المنيو 😅`;
            }

            let foundItems = [];
            menuItems.forEach(item => {
                let itemName = item.name.toLowerCase();
                if (q.includes(itemName) || itemName.includes(q)) {
                    foundItems.push(item);
                }
            });

            if (foundItems.length > 0) {
                let reply = 'أيوه 👌 لقيتلك في منيو Y&A:<br><br>';
                foundItems.forEach(item => {
                    reply += '🍽️ <b>' + item.name + '</b> — ' + item.price + ' ج.م<br>';
                });
                return reply;
            }

            let keywords = ['برجر', 'بيتزا', 'سندوتش', 'وجبة', 'قهوة', 'قهوه', 'نسكافيه', 'كابتشينو', 'عصير', 'مشروب', 'مشروبات', 'ساقعة', 'بارد', 'ايس كوفي', 'بوب كورن', 'هو شوكلت'];

            for (let i = 0; i < keywords.length; i++) {
                let keyword = keywords[i];
                if (q.includes(keyword)) {
                    let results = menuItems.filter(item => item.name.toLowerCase().includes(keyword));
                    if (results.length > 0) {
                        let reply = 'تمام 👌 دي الحاجات اللي لقيتها في Y&A:<br><br>';
                        results.forEach(item => {
                            reply += '🍽️ <b>' + item.name + '</b> — ' + item.price + ' ج.م<br>';
                        });
                        return reply;
                    }
                }
            }

            if (q.includes('مشروب') || q.includes('مشروبات') || q.includes('ساقعة') || q.includes('بارد') || q.includes('عصير') || q.includes('قهوة') || q.includes('نسكافيه')) {
                let drinkResults = menuItems.filter(item => {
                    let name = item.name.toLowerCase();
                    return name.includes('قهوة') || name.includes('نسكافيه') || name.includes('كابتشينو') || name.includes('كوفي') || name.includes('عصير') || name.includes('مشروب') || name.includes('شاي') || name.includes('شوكلت') || name.includes('ميلك شيك') || name.includes('موهيتو');
                });

                if (drinkResults.length > 0) {
                    let reply = '🥤 تمام، دي المشروبات المتاحة في Y&A:<br><br>';
                    drinkResults.forEach(item => {
                        reply += '🥤 <b>' + item.name + '</b> — ' + item.price + ' ج.م<br>';
                    });
                    return reply;
                }
            }

            if (q.includes('ازيك') || q.includes('مرحبا') || q.includes('السلام') || q.includes('أهلاً')) {
                return `أهلاً بيك يا فنان في مطعم Y&A 🤖❤️<br><br>أنا مساعدك الذكي. اسألني عن المنيو الموسع أو عن إحصائيات المبيعات والأرباح!`;
            }

            return `تمام يا فنان 🤖👌 أقدر أساعدك تختار من منيو Y&A أو تشوف إحصائيات المطعم والمبيعات.`;
        }
    </script>

</body>
</html>