<?php

namespace App\Repositories;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\History;
use App\Enums\HistoryTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use App\Models\HistoryDetail;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository con     *

     * @param History $history
     */
    public function __construct(History $history)
    {
        parent::__construct($history);
    }

    public function getList($params, $id)
    {
        $comments = $this->model::with('historyDetail')->where('histories.request_id', '=', $id)
        ->Where('histories.type', '<>', HistoryTypeEnum::HISTORY_TYPE_CREATE)
        ->leftJoin('users', 'user_id', '=', 'users.id')
        ->select(
            'histories.id',
            'request_id',
            'user_id',
            'name',
            'content',
            'histories.created_at',
            'type',
        )
        ->orderBy('histories.created_at', 'desc');
        return $comments;
    }
}
