<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * RoleRepository con     *

     * @param Role $role
     */
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function getColumns($columns = ['*'], $with = [])
    {
        return $this->model->select('id', 'name')->with($with);
    }
}
