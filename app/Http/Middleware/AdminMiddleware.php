<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;    

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // $user = Auth::user();

        // // Kiểm tra nếu user có bất kỳ vai trò nào trong danh sách
        // if (!$user->roles()->whereIn('name', $roles)->exists()) {
        //     abort(403, 'Bạn không có quyền truy cập.');
        // }

        return $next($request);
    }
}