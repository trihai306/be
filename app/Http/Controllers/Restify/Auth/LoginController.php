<?php

namespace App\Http\Controllers\Restify\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Thêm thông báo lỗi tiếng Việt cho việc xác thực nhập liệu
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Địa chỉ email không tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ];

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ], $messages);

        /** * @var User $user */

        if (!$user = config('restify.auth.user_model')::query()
            ->whereEmail($request->input('email'))
            ->first()) {
            return response()->json(['error' => 'Thông tin đăng nhập không hợp lệ.'], 401);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['error' => 'Thông tin đăng nhập không hợp lệ.'], 401);
        }
        $user = User::find($user->id);
        return data([
            'user' => $user,
            'accessToken' => $user->createToken('login'),
        ]);
    }
}
