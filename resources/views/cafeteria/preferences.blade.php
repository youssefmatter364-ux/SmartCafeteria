<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفضيلات الذكاء الاصطناعي - الكافتيريا الذكية</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">🤖 حدد تفضيلاتك للذكاء الاصطناعي</h1>
            <p class="text-gray-600 mb-6">ساعد نظام الذكاء الاصطناعي في ترشيح أفضل الأكلات المناسبة لذوقك وميزانيتك بدقة عالية.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('customer.preferences.update') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">الأقسام المفضلة (مثال: وجبات سريعة، مشروبات، حلويات)</label>
                    <input type="text" name="favorite_categories" value="{{ old('favorite_categories', $preference->favorite_categories) }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">الطعم المفضل (مثال: حار، حلو، مالح، مدخن)</label>
                    <input type="text" name="preferred_taste" value="{{ old('preferred_taste', $preference->preferred_taste) }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">التفضيلات الغذائية (مثال: نباتي، دايت، خالي من الجلوتين)</label>
                    <input type="text" name="dietary_preferences" value="{{ old('dietary_preferences', $preference->dietary_preferences) }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">أقصى ميزانية للوجبة (بالجنيه)</label>
                    <input type="number" step="0.01" name="max_budget" value="{{ old('max_budget', $preference->max_budget) }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">مستوى الحرقان (من 0 هادئ إلى 3 ناري جداً)</label>
                    <select name="spicy_level" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="0" {{ $preference->spicy_level == 0 ? 'selected' : '' }}>0 - بدون شطة (هادئ)</option>
                        <option value="1" {{ $preference->spicy_level == 1 ? 'selected' : '' }}>1 - خفيف</option>
                        <option value="2" {{ $preference->spicy_level == 2 ? 'selected' : '' }}>2 - متوسط</option>
                        <option value="3" {{ $preference->spicy_level == 3 ? 'selected' : '' }}>3 - حار جداً (ناري)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">مكونات تحبها (افصل بينها بفواصل)</label>
                    <input type="text" name="favorite_ingredients" value="{{ old('favorite_ingredients', $preference->favorite_ingredients) }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="مثال: جبنة، كاتشب، مشروم">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">مكونات تكرهها أو تحذر منها (افصل بينها بفواصل)</label>
                    <input type="text" name="disliked_ingredients" value="{{ old('disliked_ingredients', $preference->disliked_ingredients) }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="مثال: بصل، طماطم، فلفل حار">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        حفظ التفضيلات وبدء الترشيحات الذكية 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>