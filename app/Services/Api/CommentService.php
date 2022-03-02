<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Contracts\Services\Api\CommentServiceInterface;
use App\Services\AbstractService;
use App\Enums\HistoryTypeEnum;

class CommentService extends AbstractService implements CommentServiceInterface
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * CommentService constructor.
     *
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param  $params
     * @return array
     */
    public function index($params, $id)
    {
        $comments = $this->commentRepository->getList($params, $id);

        if (!isset($params['per_page'])) {
            $params['per_page'] = 10;
        }
        if (!isset($params['current_page'])) {
            $params['current_page'] = 1;
        }
        $list = $comments->paginate($params['per_page'], ['*'], 'currentPage', $params['current_page']);
        foreach ($list as &$comment) {
            if ($comment->type == HistoryTypeEnum::HISTORY_TYPE_UPDATE) {
                if (!empty($comment->historyDetail)) {
                    $comment->content = $comment->historyDetail;
                    unset($comment->historyDetail);
                }
            }
            unset($comment->historyDetail);
        }
        return [
            'message'=> 'Success',
            'total_record'=> $list->total(),
            'data' => $list->items(),
        ];
    }
}
