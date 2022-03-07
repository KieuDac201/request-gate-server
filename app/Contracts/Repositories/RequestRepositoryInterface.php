<?php

namespace App\Contracts\Repositories;

interface RequestRepositoryInterface extends BaseRepositoryInterface
{
    public function detail($id);
}
