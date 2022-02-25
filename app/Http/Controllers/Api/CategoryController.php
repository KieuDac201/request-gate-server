<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CategoryServiceInterface;
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
}
