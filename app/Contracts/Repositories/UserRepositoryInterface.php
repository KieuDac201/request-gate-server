<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getList($params);

    public function loginGmail($params);

    public function changePassword(User $user, $params);
}
