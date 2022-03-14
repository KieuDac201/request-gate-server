<?php

namespace App\Services\Api;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Enums\DepartmentEnum;
use App\Models\User;
use App\Services\AbstractService;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\RoleEnum;
use App\Exceptions\QueryException;
use App\Exceptions\CheckAuthorizationException;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserStatusEnum;

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
        $params['password'] = Hash::make($params['password']);
        if ($params['role_id'] == RoleEnum::ROLE_QUAN_LY_BO_PHAN) {
            $user = User::where('role_id', '=', RoleEnum::ROLE_QUAN_LY_BO_PHAN)
            ->where('department_id', '=', $params['department_id'])-> get();
            if ($user->count() > 0) {
                throw new QueryException('Da co 1 truong bo phan');
            }
        }

        if ($params['role_id'] == RoleEnum::ROLE_ADMIN && $params['department_id'] != DepartmentEnum::DEPARTMENT_HCNS) {
            throw new QueryException('Phong nay khong duoc them Admin');
        }

        if ($params['email']) {
            $checkemail = User::where('email', '=', $params['email'])->get();
            if ($checkemail->count() > 0) {
                throw new QueryException('Email nay da ton tai');
            }
        }

        return [
            'message' => 'them thanh cong',
            'data' => $this->userRepository->store($params)
        ];
    }

    public function update(User $user, $params)
    {
        if ($params['role_id'] == RoleEnum::ROLE_QUAN_LY_BO_PHAN) {
            $checkuser = User::where('role_id', '=', RoleEnum::ROLE_QUAN_LY_BO_PHAN)
            ->where('department_id', '=', $params['department_id'])->first();

            if ($checkuser->count() > 0 && $checkuser->id != $user->id) {
                throw new QueryException('Da co 1 truong bo phan');
            }
        }

        if ($params['role_id'] == RoleEnum::ROLE_ADMIN && $params['department_id'] != 2) {
            throw new QueryException('Phong nay khong duoc them Admin');
        }

        return [
            'message' => 'update thanh cong',
            'data'  => $this->userRepository->update($user, $params)
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

    public function loginGmail($params)
    {
        $userInfo = file_get_contents(
            'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$params['access_token']
        );
        $explodeUserInfo = explode(',', $userInfo);

        if (isset($explodeUserInfo[5])) {
            $email = substr($explodeUserInfo[5], 13, -1);
        } else {
            throw new CheckAuthorizationException('Invalid token');
        }

        if (isset($email) && explode("@", $email)[1] == 'hblab.vn') {
            $user = $this->userRepository->loginGmail($email);
            $token = $user->createToken('auth_token')->plainTextToken;
            if ($user && $user->status == UserStatusEnum::USER_ACTIVE_STATUS) {
                return [
                    'token' => $token,
                    'message'=> 'Login google successfully',
                    'data' => $user
                    ];
            } elseif (!$user && $user->status == UserStatusEnum::USER_DEACTIVE_STATUS || !$user) {
                throw new CheckAuthorizationException('Email does not belong to organization');
            } else {
                throw new CheckAuthorizationException('Email does not belong to organization');
            }
        } else {
            throw new CheckAuthorizationException('Email does not belong to organization');
        }
    }
    public function changePassword(User $user, $params)
    {
        if (!(Hash::check($params['old_password'], $user->password))) {
            throw new QueryException('Old password is incorrect');
        }
        $this->userRepository->changePassword($user, $params);
        return [
            'message' => 'Success'
        ];
    }
}
