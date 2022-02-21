<?php

namespace App\Contracts\Services\Api;

use App\Models\User;

interface UserServiceInterface
{
    public function index($params);

    public function find($params);

    public function store($id);

    public function update(User $user, $id);

    public function destroy(User $user);
}
