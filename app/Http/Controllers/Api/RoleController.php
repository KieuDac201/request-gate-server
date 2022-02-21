<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    public function index(Request $request, RoleServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }
}
