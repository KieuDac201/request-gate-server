<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DepartmentStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Exceptions\QueryException;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    public function getList($params)
    {
        $data = $this->model->select('id', 'name', 'status');
        if (isset($params)) {
            $data->where('departments.name', 'like', '%'.$params.'%');
        }
        return $data->get();
    }

    public function destroy(Model $model)
    {
        $countUser = DB::table('users')->where('department_id', $model->id)->count();
        if ($countUser == 0) {
            return $model->update(['status' => DepartmentStatusEnum::DEPARMENT_DEACTIVE_STATUS]);
        } else {
            throw new QueryException('The department has members,cant be deactive');
        }
    }
}
