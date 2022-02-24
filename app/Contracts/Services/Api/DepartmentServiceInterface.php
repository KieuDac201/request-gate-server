<?php

namespace App\Contracts\Services\Api;

use App\Models\Department;

interface DepartmentServiceInterface
{
    public function index($params);

    public function find($params);

    public function store($id);

    public function update(Department $department, $id);

    public function destroy(Department $department);
}
