<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // السماح لطلبات تسجيل الخروج بالمرور مباشرة لمنع أي حلقة تكرارية
        if ($request->is('logout')) {
            return $next($request);
        }

        // إذا لم يكن المستخدم مسجلاً للدخول أصلاً، يتم توجيهه لصفحة تسجيل الدخول
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // التحقق مما إذا كان المستخدم يمتلك صلاحية الأدمن في قاعدة البيانات
        if (auth()->user()->role !== 'admin') {
            // إظهار رسالة خطأ توضح الـ Role الحالي لمساعدتك في المراجعة
            abort(403, 'عذراً، هذا الحساب ليس لديه صلاحية الأدمن. الـ Role الحالي هو: ' . auth()->user()->role);
        }

        // إذا كان أدمن فعلاً، السماح له بالمرور للمسار المطلوب
        return $next($request);
    }
}