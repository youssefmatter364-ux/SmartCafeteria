<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CafeteriaController;
use App\Http\Controllers\CafeteriaFrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerPreferenceController;

// مسارات الموقع العامة
Route::get('/cafeteria/menu', [CafeteriaController::class, 'index']);
Route::get('/cafeteria/ai-search', [CafeteriaController::class, 'aiSearch'])->name('cafeteria.search');
Route::get('/cafeteria/item/{type}/{id}', [CafeteriaController::class, 'showItem']);
Route::get('/menu', [CafeteriaFrontendController::class, 'index']);
Route::post('/order/store', [OrderController::class, 'store']);
Route::post('/order/cancel', [OrderController::class, 'cancelOrder']);

// 1. عرض صفحة تسجيل الدخول
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 2. معالجة تسجيل الدخول (موجهة مباشرة لـ /login بطريقة POST)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/orders');
    }

    return back()->withErrors([
        'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
    ])->onlyInput('email');
});

// 3. مسارات لوحة التحكم المحمية بالكامل
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
    Route::get('/admin/orders/all', [OrderController::class, 'allOrdersIndex']);
    Route::post('/admin/orders/{id}/confirm', [OrderController::class, 'confirmOrder']);
    Route::post('/admin/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);

    Route::get('/customer/preferences', [CustomerPreferenceController::class, 'edit'])->name('customer.preferences.edit');
    Route::post('/customer/preferences', [CustomerPreferenceController::class, 'update'])->name('customer.preferences.update');
});

// 4. مسار تسجيل الخروج
Route::match(['get', 'post'], '/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
Route::get('/', function () {
    return redirect('/menu');
});