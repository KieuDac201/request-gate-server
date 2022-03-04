<?php

namespace App\Services\Api;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Enums\RequestStatusEnum;
use App\Enums\RoleEnum;
use App\Exceptions\QueryException;
use App\Jobs\SendMail;
use App\Exceptions\NotFoundException;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestService extends AbstractService implements RequestServiceInterface
{
    protected $requestRepository;

    public function __construct(RequestRepositoryInterface $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    public function index($params)
    {
        if (!isset($params['per_page'])) {
            $params['per_page'] = 10;
        }
        if (!isset($params['current_page'])) {
            $params['current_page'] = 1;
        }

        $listRequest = json_decode(json_encode($this->requestRepository
        ->getList($params)->paginate($params['per_page'], ['*'], 'currentPage', $params['current_page'])), true);
        return [
            'current_page' => $listRequest['current_page'],
            'data' => $listRequest['data'],
            'total' => $listRequest['total'],
            'total_page' => ceil($listRequest['total'] / $params['per_page']),
        ];
    }

    public function store($params)
    {
        $data = $this->requestRepository->store($params);
        return [
            'message' => 'Them thanh cong',
            'data'  => $data,
        ];
    }

    public function update(Request $request, $params)
    {
        if ($request->status == RequestStatusEnum::REQUEST_STATUS_OPEN &&
            Auth::User()->role_id == RoleEnum::ROLE_CAN_BO_NHAN_VIEN &&
            $request->status != $params['status']) {
            throw new QueryException('Can bo nhan vien khong duoc update status');
        }

        if ($request->status != RequestStatusEnum::REQUEST_STATUS_OPEN &&
            Auth::User()->role_id == RoleEnum::ROLE_CAN_BO_NHAN_VIEN) {
            throw new QueryException('Can bo nhan vien khong duoc update request nay');
        }

        if ($request->status == RequestStatusEnum::REQUEST_STATUS_CLOSE &&
            Auth::User()->role_id != RoleEnum::ROLE_ADMIN) {
            throw new QueryException('Admin moi duoc update status');
        }

        if ($request->person_in_charge != $params['person_in_charge'] &&
            Auth::User()->role_id != RoleEnum::ROLE_ADMIN) {
            throw new QueryException('Admin moi thay doi duoc Assign');
        }

        if ($request->priority != $params['priority'] &&
            Auth::User()->role_id != RoleEnum::ROLE_ADMIN) {
            throw new QueryException('Admin moi thay doi duoc priority');
        }

        if (Auth::User()->role_id == RoleEnum::ROLE_QUAN_LY_BO_PHAN &&
            Auth::User()->depaerment_id != $request->createby->department_id) {
            throw new QueryException('Khong cung phong ban nen khong update status');
        }

        if ($this->requestRepository->update($request, $params)) {
            return [
                'message' => 'Update thanh cong '
            ];
        }
    }
    public function detail($id)
    {
        if (!isset($id)) {
            throw new NotFoundException('Request does not exist or has been deleted');
        } else {
            $data = $this->requestRepository->detail($id);
            return [
                'data' => $data
            ];
        }
    }
}
