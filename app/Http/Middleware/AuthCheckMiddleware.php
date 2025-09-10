<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthCheckMiddleware
{
    /**
     * التحقق من تسجيل دخول المستخدم باستثناء صفحات معينة
     */
    public function handle(Request $request, Closure $next)
    {
        // قائمة المسارات المسموح بها بدون تسجيل دخول
        $allowedRoutes = [
            'login',
            'register' // يمكنك إزالة هذا إذا كنت لا تريد السماح بالتسجيل بدون تسجيل دخول
        ];

        // التحقق مما إذا كان المستخدم غير مسجل دخول والمسار الحالي ليس في القائمة المسموح بها
      #  if (!Auth::check() && !in_array(Route::currentRouteName(), $allowedRoutes)) {
       #     return redirect()->route('login');
        #}

        return $next($request);
    }
}