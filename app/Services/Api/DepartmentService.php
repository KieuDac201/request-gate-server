<?php

namespace App\Services\Api;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Models\Department;
use App\Services\AbstractService;
use App\Exceptions\QueryException;
use Illuminate\Support\Facades\Cache;

class DepartmentService extends AbstractService implements DepartmentServiceInterface
{

    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index($params)
    {
        return [
            'data' => $this->departmentRepository->getList($params)
        ];
    }

    public function find($params)
    {
        return [
            'data' => $this->departmentRepository->find($params)
        ];
    }

    public function store($params)
    {
        $checkDepartment = $this->departmentRepository->checkDepartment($department_id = null, $params);
        if ($checkDepartment > 0) {
            throw new QueryException('This department name already exists');
        }
        $data = $this->departmentRepository->store($params);
        $value = Cache::get('departments');
        $value[] = $data;
        Cache::put('departments', $value);
        return [
            'message' => 'Success',
            'data' => $data
        ];
    }

    public function update(Department $department, $params)
    {
        $checkDepartment = $this->departmentRepository->checkDepartment($department->id, $params);
        if ($checkDepartment > 0) {
            throw new QueryException('This department name already exists');
        }
        if ($this->departmentRepository->update($department, $params)) {
            Cache::forget('departments');
            $this->departmentRepository->getList($params = null);
            return [
                'message' => 'Success'
            ];
        }
    }

    public function destroy(Department $department)
    {
        //
    }
}
