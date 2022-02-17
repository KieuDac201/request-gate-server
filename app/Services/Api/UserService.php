<?php

namespace App\Services\Api;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Models\User;
use App\Services\AbstractService;

class UserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        return $this->userRepository->getColumns()->get();
    }

    public function find($params)
    {
        return $this->userRepository->find($params);
    }

    public function store($params)
    {
        return [
            'message'=>9,
            'data' => $this->userRepository->store($params)
        ];
    }

    public function update(User $user, $params)
    {
        return $this->userRepository->update($user, $params);
    }

    public function destroy(User $user)
    {
        return $this->userRepository->destroy($user);
    }
}
