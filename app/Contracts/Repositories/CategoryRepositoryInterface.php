<?php

namespace App\Contracts\Repositories;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getList($params);
}
