<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserStatusEnum;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getList($param)
    {
        $data = $this->model->join('departments', 'department_id', '=', 'departments.id')
            ->join('roles', 'role_id', '=', 'roles.id')
            ->select(
                'users.id as id',
                'users.name as name',
                'code',
                'departments.name as department_name',
                'departments.id as department_id',
                'roles.name as role_name',
                'roles.id as role_id',
                'users.status'
            );
        if (isset($param)) {
            $data->where('users.name', 'like', '%'.$param.'%')
            ->orWhere('users.code', 'like', '%'.$param.'%');
        }
        return $data->get();
    }

    public function destroy(Model $model)
    {
        return $model->update(['status' => UserStatusEnum::USER_DEACTIVE_STATUS]);
    }
}
