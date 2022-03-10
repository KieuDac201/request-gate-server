<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\HistoryServiceInterface;
use App\Http\Requests\Api\Users\IndexRequest;
use App\Http\Requests\Api\Histories\PostCommentRequest;

class HistoryController extends ApiController
{
    public function index(IndexRequest $request, HistoryServiceInterface $serviceService, $id)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params, $id) {
            return $serviceService->index($params, $id);
        });
    }

    public function getList(IndexRequest $request, HistoryServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params, $id = null);
        });
    }

    public function addComment(PostCommentRequest $request, HistoryServiceInterface $serviceService)
    {
        $data = $request->all();
        return $this->doRequest(function () use ($serviceService, $data) {
            return $serviceService->addComment($data);
        });
    }
}
