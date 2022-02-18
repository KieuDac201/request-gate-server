<?php

namespace App\Services\Api;

use App\Repositories\ForgotResetPasswordRepository;
use App\Services\AbstractService;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotResetPasswordService extends AbstractService
{
    
    protected $forgotResetPasswordRepository;

    
    public function __construct(ForgotResetPasswordRepository $forgotResetPasswordRepository)
    {
        $this->forgotResetPasswordRepository = $forgotResetPasswordRepository;
    }

    public function forgotPassword($params)
    {
        $status = Password::sendResetLink($params);
        if ($status == Password::RESET_LINK_SENT) {
            return [
                'message' => 'We have e-mailed your password reset link!'
            ];
        }
    }

    public function resetPassword(User $user, $params)
    {
        $status = Password::reset(
            $params,
            function ($user) use ($params) {
                $this->forgotResetPasswordRepository->resetPassword($user, $params);
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }
        return response([
            'message'=> __($status)
        ], 500);
    }
}
