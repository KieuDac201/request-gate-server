<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ForgotResetPasswordRepository extends BaseRepository
{
    /**
     * ForgotResetPasswordRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function resetPassword(Model $model, array $data)
    {   
        $model->forceFill([
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(60),
        ])->save();

        $model->tokens()->delete();

        event(new PasswordReset($model));
    }
}
