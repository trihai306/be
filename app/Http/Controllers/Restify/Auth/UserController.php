<?php
namespace App\Http\Controllers\Restify\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $user = auth()->user();

        // Lấy ra tất cả các vai trò của người dùng
        $roles = $user->getRoleNames(); // trả về một collection
        // Lấy ra các quyền cho mỗi vai trò
        $rolesAndPermissions = [];
        foreach($roles as $role) {
            $rolePermissions = $user->getRole($role)->permissions;
            $rolesAndPermissions[$role] = $rolePermissions;
        }

        return data([
            'user' => $user,
            'roles' => $rolesAndPermissions,
        ]);
    }
}
