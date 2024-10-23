<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginApi extends Controller
{
    public function loginApi(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if (!$user) {
                    throw new \Exception('User instance is null');
                }

                if (empty($user->remember_token)) {
                    $newToken = Str::random(60);
                    $user->remember_token = $newToken;

                    if (!($user instanceof User)) {
                        throw new \Exception('The $user is not an instance of User');
                    }

                    $user->save();
                }

                return response()->json([
                    'remember_token' => $user->remember_token,
                    'message' => 'Đăng nhập thành công',
                    'user' => $user
                ], 200);
            }

            return response()->json(['error' => 'Đăng nhập thất bại, kiểm tra lại thông tin!!!'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi xử lý đăng nhập: ' . $e->getMessage()], 500);
        }
    }
    public function logoutApi(Request $request)
    {
        try {
            // Lấy người dùng hiện tại từ token
            $user = Auth::user();

            if ($user) {
                // Không xóa token, chỉ trả về phản hồi rằng người dùng đã logout
                return response()->json([
                    'message' => 'Đăng xuất thành công, token vẫn hợp lệ.'
                ], 200);
            }

            return response()->json(['error' => 'Người dùng không tồn tại hoặc chưa đăng nhập.'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi xử lý đăng xuất: ' . $e->getMessage()], 500);
        }
    }
}