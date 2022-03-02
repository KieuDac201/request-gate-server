<?php

namespace App\Services\Api;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Models\Request;
use App\Services\AbstractService;

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
}
