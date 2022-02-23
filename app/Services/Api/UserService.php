<?php

namespace App\Services\Api;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Models\User;
use App\Services\AbstractService;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Builder;

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
        return [
            'data' => $this->userRepository->getList($params)
        ];
    }

    public function find($params)
    {
        return [
            'data' => $this->userRepository->find($params)
        ];
    }

    public function store($params)
    {
        if ($params['role_id'] == 2) {
            $user = User::where('role_id', '=', 2)
            ->where('department_id', '=', $params['department_id'])->get();
            if ($user->count()>0) {
                return [
                    'message'   => 'Da co 1 truong bo phan',
                ];
            }
        }

        if ($params['role_id'] == 1 && $params['department_id'] != 2) {
            return [
                'message'   => 'Phong nay khong duoc them Admin',
            ];
        }

        return [
            'message'=> 'them thanh cong',
            'data' => $this->userRepository->store($params)
        ];
    }

    public function update(User $user, $params)
    {
        if ($params['role_id'] == 2) {
            $user = User::where('role_id', '=', 2)
            ->where('department_id', '=', $params['department_id'])->get();

            if ($user->count()>0) {
                return [
                    'message'   => 'Da co 1 truong bo phan',
                ];
            }
        }

        if ($params['role_id'] == 1 && $params['department_id'] != 2) {
            return [
                'message'   => 'Phong nay khong duoc them Admin',
            ];
        }
        
        return [
            'message'=>'update thanh cong',
            'data'  =>$this->userRepository->update($user, $params)
        ];
    }

    public function destroy(User $user)
    {
        if ($this->userRepository->destroy($user)) {
            return [
                'message' => 'Success'
            ];
        }
    }
}
