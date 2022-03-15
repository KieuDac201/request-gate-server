<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

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
        $value = Cache::remember('roles', Carbon::now()->addMinutes(30), function () {
            return $this->model->select('id', 'name')->get();
        });
        return $value;
    }
}
