<?php

namespace App\Contracts\Repositories;

interface HistoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getList($params, $id);
}
