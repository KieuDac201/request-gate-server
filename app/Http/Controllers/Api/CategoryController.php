<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Http\Requests\Api\Categories\UpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Categories\StoreRequest;

class CategoryController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(Request $request, CategoryServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }
    public function search(Request $request, CategoryServiceInterface $serviceService)
    {
        if ($request->key) {
            $key = $request->key;
            return $this->doRequest(function () use ($serviceService, $key) {
                return $serviceService->search($key);
            });
        }
    }
    public function store(StoreRequest $request, CategoryServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $params) {
            return $serviceService->store($params);
        });
    }
    public function update(UpdateRequest $request, CategoryServiceInterface $serviceService, $id)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($serviceService, $data, $id) {
            return $serviceService->update($data, $id);
        });
    }
    public function destroy(CategoryServiceInterface $serviceService, $id)
    {
        return $this->doRequest(function () use ($serviceService, $id) {
            return $serviceService->destroy($id);
        });
    }
}
