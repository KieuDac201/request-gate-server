<?php

namespace App\Contracts\Repositories;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function getList($params, $id);
}
