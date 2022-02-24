<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Http\Requests\Api\DepartmentRequest;

class DepartmentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, DepartmentServiceInterface $serviceService)
    {
        $params = $request->key;
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }

    public function show($id, DepartmentServiceInterface $serviceService)
    {
        return $this->getData(function () use ($serviceService, $id) {
            return $serviceService->find($id);
        });
    }

    public function store(DepartmentRequest $request, DepartmentServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $params) {
            return $serviceService->store($params);
        });
    }

    public function update(
        DepartmentRequest $request,
        DepartmentServiceInterface $serviceService,
        Department $department
    ) {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $department, $params) {

            return $serviceService->update($department, $params);
        });
    }

    public function destroy(DepartmentServiceInterface $serviceService, Department $department)
    {
        return $this->doRequest(function () use ($serviceService, $department) {
            return $serviceService->destroy($department);
        });
    }
}
