<?php

namespace App\Services\Api;

use App\Contracts\Repositories\HistoryRepositoryInterface;
use App\Contracts\Services\Api\HistoryServiceInterface;
use App\Services\AbstractService;
use App\Enums\HistoryTypeEnum;

class HistoryService extends AbstractService implements HistoryServiceInterface
{
    /**
     * @var historyRepositoryInterface
     */
    protected $historyRepository;

    /**
     * HistoryService constructor.
     *
     * @param HistoryRepositoryInterface $historyRepository
     */
    public function __construct(HistoryRepositoryInterface $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    /**
     * @param  $params
     * @return array
     */
    public function index($params, $id)
    {
        $histories = $this->historyRepository->getList($params, $id);

        if (!isset($params['per_page'])) {
            $params['per_page'] = 10;
        }
        if (!isset($params['current_page'])) {
            $params['current_page'] = 1;
        }
        $list = $histories->paginate($params['per_page'], ['*'], 'currentPage', $params['current_page']);
        foreach ($list as &$history) {
            if ($history->type == HistoryTypeEnum::HISTORY_TYPE_UPDATE) {
                if (!empty($history->historyDetail)) {
                    $history->content = $history->historyDetail;
                    unset($history->historyDetail);
                }
            }
            unset($history->historyDetail);
        }
        return [
            'message'=> 'Success',
            'total_record'=> $list->total(),
            'data' => $list->items(),
        ];
    }
}
