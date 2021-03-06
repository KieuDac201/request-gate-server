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
use App\Repositories\HistoryRepository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CheckAuthorizationException;
use Carbon\Carbon;

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
        $date = date((new Carbon($params['due_date']))->toDateString());
        $now =  date(Carbon::now()->toDateString());
        if ($date < $now) {
            throw new QueryException('The due date must be a date after yesterday.');
        }
        $data = $this->requestRepository->store($params);
        HistoryRepository::addCreateHistory($data);
        $users = $this->requestRepository->getUser(
            $params['person_in_charge'],
            $data->createBy->department_id,
            $authorId = null
        );
        $message = $this->message($data, $type = 'Create', $status = 'Open');
        // SendMail::dispatch($message, $users)->delay(now()->addMinute(1));
        return [
            'message' => 'Success',
            'data'  => $data,
        ];
    }

    public function update(Request $request, $params)
    {
        $date = date((new Carbon($params['due_date']))->toDateString());
        $now =  date(Carbon::now()->toDateString());
        if ($date < $now) {
            throw new QueryException('The due date must be a date after yesterday.');
        }
        if ($request->status == RequestStatusEnum::REQUEST_STATUS_OPEN &&
            Auth::User()->role_id == RoleEnum::ROLE_CAN_BO_NHAN_VIEN &&
            $request->status != $params['status']) {
            throw new QueryException('CBNV not update status');
        }

        if ($request->status != RequestStatusEnum::REQUEST_STATUS_OPEN &&
            Auth::User()->role_id == RoleEnum::ROLE_CAN_BO_NHAN_VIEN) {
            throw new QueryException('CBNV not update status request');
        }

        if ($request->status == RequestStatusEnum::REQUEST_STATUS_CLOSE &&
            Auth::User()->role_id != RoleEnum::ROLE_ADMIN) {
            throw new QueryException('Admin just update status');
        }

        if ($request->person_in_charge != $params['person_in_charge'] &&
            Auth::User()->role_id == RoleEnum::ROLE_QUAN_LY_BO_PHAN) {
            throw new QueryException('QLBP not update Assign');
        }

        if ($request->priority != $params['priority'] &&
            Auth::User()->role_id == RoleEnum::ROLE_QUAN_LY_BO_PHAN) {
            throw new QueryException('QLBP not update Priority');
        }

        HistoryRepository::addUpdateHistory($request, $params);
        $data = $this->requestRepository->update($request, $params);
        $users = $this->requestRepository->getUser(
            $params['person_in_charge'],
            $departmentId = null,
            $request['author_id']
        );
        $status = null;
        if ($params['status'] == RequestStatusEnum::REQUEST_STATUS_OPEN) {
            $status = 'Open';
        } elseif ($params['status'] == RequestStatusEnum::REQUEST_STATUS_IN_PROGRESS) {
            $status = 'In Progress';
        } elseif ($params['status'] == RequestStatusEnum::REQUEST_STATUS_CLOSE) {
            $status = 'Close';
        }
            $message = $this->message($request, $type = 'Update', $status);

            // SendMail::dispatch($message, $users)->delay(now()->addMinute(1));
        if ($this->requestRepository->update($request, $params)) {
            return [
                'message' => 'Success',
                'data'  => $data,
            ];
        }
    }
    public function detail($id)
    {
        $data = $this->requestRepository->detail($id);
        return [
            'data' => $data
        ];
    }

    public function action($id, $params)
    {
        $request = Request::where('id', $id)->first();
        if (!isset($request)) {
            throw new NotFoundException('request does not exist');
        }

        $user = Auth::user();
        $idTPB = $this->requestRepository->getDivisionManager($request->id);
        $isTPB = ($user->id == $idTPB) ? true : false;
        if (!$isTPB) {
            throw new CheckAuthorizationException('You do not have permission');
        }
        if ($this->requestRepository->approved($request->id) == true) {
            throw new QueryException('This request has been approved');
        }
        if ($params == "approve") {
            if ($request->status != RequestStatusEnum::REQUEST_STATUS_OPEN) {
                throw new QueryException('This request is not open');
            }
            HistoryRepository::addActionHistory($request->id, $user->id, $params);
            return [
                'message' => 'Approve success'
                ];
        }
        if ($params == "reject") {
            if (!in_array($request->status, [RequestStatusEnum::REQUEST_STATUS_OPEN,
                                             RequestStatusEnum::REQUEST_STATUS_IN_PROGRESS])) {
                throw new QueryException('This request is not open or in progress');
            }
            if ($this->requestRepository->reject($request)) {
                HistoryRepository::addActionHistory($request->id, $user->id, $params);
                return [
                    'message' => 'Success'
                ];
            }
        }
    }
    public function destroy(Request $request)
    {
        if (Auth::user()->id != $request->author_id) {
            throw new CheckAuthorizationException('You are not allowed to perform this action');
        }
        if ($request->status != RequestStatusEnum::REQUEST_STATUS_OPEN) {
            throw new QueryException('You can only delete request in open state');
        }
        if ($this->requestRepository->destroy($request)) {
            return [
                'message' => 'Success'
            ];
        }
    }
    public function message($data, $type, $status)
    {
        $message = [
            'day' => Carbon::now()->toFormattedDateString(), 'title' => $data['name'],
            'type' => $type, 'name' => Auth::User()->name, 'status' => $status,
            'category_name' => $data->category->name,'person_in_charge' => $data->assigneeby->name,
            'link' => config('settings.webAppUrl').'/requests', 'id' => $data['id']
        ];
        return $message;
    }
}
