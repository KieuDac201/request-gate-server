<?php
namespace App\Services\Api;

use App\Services\AbstractService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CheckAuthenticationException;

class LoginService extends AbstractService
{
    public function login($params)
    {
        if (!Auth::attempt($params)) {
            throw new CheckAuthenticationException();
        }
            $user = User::where('email', $params['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return ([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'message' => 'User logged in successfully',
                'data' => $user
            ]);
    }
}
