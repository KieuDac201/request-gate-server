<?php

namespace App\Contracts\Services\Api;

use App\Models\User;

interface UserServiceInterface
{
    public function index($params);
    public function store($params);
    public function update(User $user, $params);
    public function destroy($params);
}
