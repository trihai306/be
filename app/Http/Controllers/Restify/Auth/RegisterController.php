<?php

namespace App\Http\Controllers\Restify\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Thêm thông báo lỗi tiếng Việt cho việc xác thực nhập liệu
        $messages = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được quá 255 ký tự.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'name.required' => 'Vui lòng nhập tên.',
        ];

        $validatedData = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:' . Config::get('restify.auth.table', 'users')],
            'password' => ['required'],
            'name' => ['required'],

            'phone' => ['nullable'],
            'address' => ['nullable'],
        ], $messages);

        $user = User::forceCreate([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([
            'data' => [
                'userData' => $user,
                'userAbilities' => 'admin',
                'accessToken' => $user->createToken('login')
            ],
        ], 200);
    }
}
