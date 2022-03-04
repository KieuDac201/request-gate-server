<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Contracts\Services\Api\RequestServiceInterface;

class RequestController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, RequestServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }
}
