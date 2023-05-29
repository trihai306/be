<?php
namespace App\Http\Controllers\Restify\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return data([
            'user' => auth()->user(),
        ]);
    }
}
