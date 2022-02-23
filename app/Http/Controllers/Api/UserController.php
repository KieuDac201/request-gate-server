<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\UserServiceInterface;
use App\Http\Requests\Api\Users\IndexRequest;
use App\Models\User;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Http\Requests\Api\Users\UpdateRequest;

class UserController extends ApiController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param IndexRequest $request
     * @param UserServiceInterface $serviceService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(IndexRequest $request, UserServiceInterface $serviceService)
    {
        $params = $request->key;
        return $this->getData(function () use ($serviceService, $params) {
            return $serviceService->index($params);
        });
    }

    public function show($id, UserServiceInterface $serviceService)
    {
        return $this->getData(function () use ($serviceService, $id) {
            return $serviceService->find($id);
        });
    }

    public function store(StoreRequest $request, UserServiceInterface $serviceService)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $params) {
            return $serviceService->store($params);
        });
    }

    public function update(UpdateRequest $request, UserServiceInterface $serviceService, User $user)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($serviceService, $user, $params) {

            return $serviceService->update($user, $params);
        });
    }

    public function destroy(UserServiceInterface $serviceService, User $user)
    {
        return $this->doRequest(function () use ($serviceService, $user) {
            return $serviceService->destroy($user);
        });
    }
}
