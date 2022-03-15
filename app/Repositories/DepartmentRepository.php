<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DepartmentStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Exceptions\QueryException;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    public function getList($params)
    {
        $value = Cache::remember('departments'.$params, Carbon::now()->addMinutes(5), function () use ($params) {
            $data = $this->model->select('id', 'name', 'status');
            if (isset($params)) {
                $data->where('departments.name', 'like', '%'.$params.'%');
            }
            return $data->get();
        });
        return $value;
    }

    public function update(Model $model, array $params)
    {
        if ($params['status'] == DepartmentStatusEnum::DEPARMENT_DEACTIVE_STATUS) {
            $countUser = DB::table('users')->where('department_id', $model->id)->count();
            if ($countUser == 0) {
                return  $model->update($params);
            } else {
                throw new QueryException('The department has members,cant be deactive');
            }
        } else {
            return  $model->update($params);
        }
    }
    public function checkDepartment($department_id, $params)
    {
        if ($department_id == null) {
            $checkDepartment = Department::where('name', '=', $params['name'])->count();
            return $checkDepartment;
        }
        $checkDepartment = Department::where('name', '=', $params['name'])
        ->where('id', '!=', $department_id)
        ->count();
        return $checkDepartment;
    }
}
