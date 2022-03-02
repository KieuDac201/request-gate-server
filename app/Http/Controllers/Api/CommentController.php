<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CommentServiceInterface;
use App\Http\Requests\Api\Users\IndexRequest;

class CommentController extends ApiController
{
    public function index(IndexRequest $request, CommentServiceInterface $serviceService, $id)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params, $id) {
            return $serviceService->index($params, $id);
        });
    }
}
