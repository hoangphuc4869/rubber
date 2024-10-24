<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Bạn chưa đăng nhập, vui lòng đăng nhập.'], 401);
        }

        // Loại bỏ "Bearer " nếu có trong token
        $token = str_replace('Bearer ', '', $token);

        // Tìm người dùng với token tương ứng trong cơ sở dữ liệu
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Token không hợp lệ hoặc đã hết hạn.'], 401);
        }

        Auth::login($user);

        return $next($request);
    }
}