<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\ForgotResetPasswordService;
use App\Http\Requests\Api\Users\ResetPasswordRequest;
use App\Http\Requests\Api\Users\ForgotPasswordRequest;
use App\Models\User;

class ForgotResetPasswordController extends ApiController
{
    public function forgotPassword(ForgotPasswordRequest $request, ForgotResetPasswordService $serviceService)
    {
        $params =  $request->only('email');
        
        return $this->getData(function () use ($serviceService, $params) {
           
            return $serviceService->forgotPassword($params);
        });
    }

    public function resetPassword(ResetPasswordRequest $request, ForgotResetPasswordService $serviceService, User $user)
    {
        $params = $request->only('email', 'password', 'password_confirmation', 'token');
        return $this->doRequest(function () use ($serviceService, $user, $params) {

            return $serviceService->resetPassword($user, $params);
        });
    }
}
