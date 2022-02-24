<?php

namespace App\Services\Api;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Models\Department;
use App\Services\AbstractService;

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
        return [
            'message' => 'Success',
            'data' => $this->departmentRepository->store($params)
        ];
    }

    public function update(Department $department, $params)
    {
        if ($this->departmentRepository->update($department, $params)) {
            return [
                'message' => 'Success'
            ];
        }
    }

    public function destroy(Department $department)
    {
        if ($this->departmentRepository->destroy($department)) {
            return [
                'message' => 'Success'
            ];
        }
    }
}
