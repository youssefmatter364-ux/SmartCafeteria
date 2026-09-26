<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\CafeteriaController;
use App\Http\Controllers\CafeteriaFrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerPreferenceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| PUBLIC / CUSTOMER
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('menu');
});


Route::get('/cafeteria/menu', [
    CafeteriaController::class,
    'index'
]);


Route::get('/cafeteria/ai-search', [
    CafeteriaController::class,
    'aiSearch'
])->name('cafeteria.search');


Route::get('/cafeteria/item/{type}/{id}', [
    CafeteriaController::class,
    'showItem'
]);


Route::get('/menu', [
    CafeteriaFrontendController::class,
    'index'
])->name('menu');


/*
|--------------------------------------------------------------------------
| CUSTOMER LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => [
            'required',
            'email',
        ],

        'password' => [
            'required',
        ],
    ]);


    if (!Auth::attempt([
        'email' => $credentials['email'],
        'password' => $credentials['password'],
        'role' => 'customer',
    ])) {

        return back()
            ->withErrors([
                'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
            ])
            ->withInput($request->only('email'));
    }


    $request->session()->regenerate();


    return redirect()
        ->intended(route('menu'));
})->name('login.store');


/*
|--------------------------------------------------------------------------
| CUSTOMER REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::post('/register', function (Request $request) {

    $validated = $request->validate([

        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users,email',
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],

    ]);


    $user = User::create([

        'name' => $validated['name'],

        'email' => $validated['email'],

        'password' => Hash::make($validated['password']),

        // أي تسجيل جديد = عميل
        'role' => 'customer',

    ]);


    Auth::login($user);

    $request->session()->regenerate();


    return redirect()->route('menu');

})->name('register.store');


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
|
| الأدمن له صفحة Login مستقلة تمامًا عن العميل.
|
*/

Route::get('/admin/login', [
    AdminController::class,
    'login'
])->name('admin.login');


Route::post('/admin/login', [
    AdminController::class,
    'authenticate'
])->name('admin.login.store');


/*
|--------------------------------------------------------------------------
| LOGGED IN CUSTOMER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    | Orders
    */

    Route::get('/my-orders', [
        OrderController::class,
        'myOrders'
    ])->name('orders.my');


    Route::post('/order/{id}/cancel', [
        OrderController::class,
        'cancelCustomerOrder'
    ])->name('order.customer.cancel');


    /*
    | Customer Order (تم نقله هنا ليكون محمي ومتاح للمستخدم المسجل دخول فقط)
    */

    Route::post('/order/store', [
        OrderController::class,
        'store'
    ])->name('order.store');


    /*
    | Customer Preferences
    */

    Route::get('/customer/preferences', [
        CustomerPreferenceController::class,
        'edit'
    ])->name('customer.preferences.edit');


    Route::post('/customer/preferences', [
        CustomerPreferenceController::class,
        'update'
    ])->name('customer.preferences.update');


    /*
    | Profile
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');


    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');


    /*
    | Favorites
    */

    Route::post('/favorites/toggle/{id}', [
        ProfileController::class,
        'toggleFavorite'
    ])->name('favorites.toggle');


    /*
    | Logout
    */

    Route::post('/logout', [
        AdminController::class,
        'logout'
    ])->name('logout');

});


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {


        /*
        | Dashboard / Orders
        */

        Route::get('/orders', [
            AdminController::class,
            'index'
        ])->name('admin.orders');


        /*
        | Categories
        */

        Route::post('/categories/store', [
            AdminController::class,
            'storeCategory'
        ])->name('admin.categories.store');


        /*
        | Menu
        */

        Route::post('/menu/store', [
            AdminController::class,
            'storeMenu'
        ])->name('admin.menu.store');


        /*
        | Food
        */

        Route::post('/food/{id}/update', [
            AdminController::class,
            'updateFood'
        ])->name('admin.food.update');


        Route::post('/food/{id}/delete', [
            AdminController::class,
            'deleteFood'
        ])->name('admin.food.delete');


        Route::post('/food/{id}/toggle', [
            AdminController::class,
            'toggleFood'
        ])->name('admin.food.toggle');


        /*
        | Beverages
        */

        Route::post('/beverage/{id}/update', [
            AdminController::class,
            'updateBeverage'
        ])->name('admin.beverage.update');


        Route::post('/beverage/{id}/delete', [
            AdminController::class,
            'deleteBeverage'
        ])->name('admin.beverage.delete');


        Route::post('/beverage/{id}/toggle', [
            AdminController::class,
            'toggleBeverage'
        ])->name('admin.beverage.toggle');


        /*
        | Orders
        */

        Route::post('/orders/{id}/confirm', [
            AdminController::class,
            'confirmOrder'
        ])->name('admin.orders.confirm');


        Route::post('/orders/{id}/cancel', [
            AdminController::class,
            'cancelOrder'
        ])->name('admin.orders.cancel');


        /*
        | Chatbot
        */

        Route::post('/chatbot/respond', [
            AdminController::class,
            'chatbotRespond'
        ])->name('chatbot.respond');

    });


/*
|--------------------------------------------------------------------------
| AUTH CHECK
|--------------------------------------------------------------------------
*/

Route::get('/check-auth', function () {

    return response()->json([

        'logged_in' => Auth::check(),

        'user_id' => Auth::id(),

        'user_name' => Auth::user()?->name,

        'user_email' => Auth::user()?->email,

        'user_role' => Auth::user()?->role,

        'session_id' => session()->getId(),

    ]);

});