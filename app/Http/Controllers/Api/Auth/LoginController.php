<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Services\Api\LoginService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Users\LoginRequest;

class LoginController extends ApiController
{

    public function loginApi(LoginRequest $request, LoginService $loginService)
    {
        $params = $request->only('email', 'password');
        return $this->doRequest(function () use ($loginService, $params) {
            return $loginService->login($params);
        });
    }
    public function logoutApi(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
