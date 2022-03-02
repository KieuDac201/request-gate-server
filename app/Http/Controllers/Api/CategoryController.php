<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Http\Requests\Api\Categories\UpdateRequest;
use App\Models\Category;
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
        $params = $request->key;
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }
    public function store(StoreRequest $request, CategoryServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $params) {
            return $serviceService->store($params);
        });
    }
    public function update(UpdateRequest $request, CategoryServiceInterface $serviceService, Category $category)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $category, $params) {
            return $serviceService->update($category, $params);
        });
    }
}
