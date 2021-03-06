<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Request\StoreRequest;
use App\Http\Requests\Api\Request\UpdateRequest;
use App\Http\Requests\Api\Users\IndexRequest;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Models\Request;

class RequestController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(IndexRequest $request, RequestServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }

    public function store(StoreRequest $request, RequestServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $params) {
            return $serviceService->store($params);
        });
    }

    public function update(UpdateRequest $data, RequestServiceInterface $serviceService, Request $request)
    {
        $params = $data->all();
        return $this->doRequest(function () use ($serviceService, $request, $params) {

            return $serviceService->update($request, $params);
        });
    }
    public function detail(RequestServiceInterface $serviceService, $id)
    {
        return $this->getData(function () use ($serviceService, $id) {
            return $serviceService->detail($id);
        });
    }
    public function action($id, RequestServiceInterface $serviceService, IndexRequest $input)
    {
        $params = $input->type;
        return $this->doRequest(function () use ($serviceService, $id, $params) {
            return $serviceService->action($id, $params);
        });
    }
    public function destroy(RequestServiceInterface $serviceService, Request $request)
    {
        return $this->doRequest(function () use ($serviceService, $request) {
            return $serviceService->destroy($request);
        });
    }
}
