<?php

namespace App\Repositories;

use App\Contracts\Repositories\HistoryRepositoryInterface;
use App\Models\History;
use App\Enums\HistoryTypeEnum;
use App\Enums\RequestPriorityEnum;
use App\Enums\RequestStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Enums\RoleEnum;

class HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{
    /**
     * HistoryRepository con     *

     * @param History $history
     */
    public function __construct(History $history)
    {
        parent::__construct($history);
    }

    public function getList($params, $id)
    {
        $data = $this->model::with('historyDetail')->leftJoin('users', 'user_id', '=', 'users.id')
        ->orderBy('histories.created_at', 'desc');
        if (isset($id)) {
            $histories = $data->where('histories.request_id', '=', $id)
            ->orWhere('users.email', 'like', '%'.$id.'%')
            ->Where('histories.type', '<>', HistoryTypeEnum::HISTORY_TYPE_CREATE)
            ->select(
                'histories.id',
                'request_id',
                'user_id',
                'name',
                'content',
                'histories.created_at',
                'type',
            );
        } else {
            $histories = $data->leftJoin('requests', 'request_id', '=', 'requests.id')
            ->select(
                'histories.id',
                'request_id',
                'requests.name as request_name',
                'user_id',
                'users.name as user_name',
                'histories.created_at',
                'type',
                'histories.content'
            );
        }
        return $histories;
    }

    public function addCreateHistory($data)
    {
        $history = new History;
        $history->request_id = $data->id;
        $history->user_id = $data->author_id;
        $history->content = 'create';
        $history->type = 'create';
        $history->save();
    }

    public function addComment($data)
    {
        $history = new History;
        $history->request_id = $data['id'];
        $history->user_id = Auth::user()->id;
        $history->content = $data['content'];
        $history->type = 'comment';
        $history->save();
        return $history;
    }

    public function addUpdateHistory($request, $params)
    {
        $history = new History;
        $history->request_id = $request->id;
        $history->user_id = $request->author_id;
        $history->content = 'update';
        $history->type = 'update';
        $history->save();

        $change = [];

        if ($request->name != $params['name']) {
            $changeField = 'Name';
            $oldValue = $request->name;
            $newValue = $params['name'];
            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }
        if ($request->content != $params['content']) {
            $changeField = 'Content';
            $oldValue = $request->content;
            $newValue = $params['content'];
            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }
        if ($request->priority != $params['priority']) {
            $changeField = 'Priority';
            $oldValue = $request->priority;
            $newValue = $params['priority'];

            if ($oldValue == RequestPriorityEnum::REQUEST_PRIORITY_NORMAL) {
                $oldValue = 'Normal';
            } else {
                $newValue = 'High';
            }

            if ($newValue == RequestPriorityEnum::REQUEST_PRIORITY_NORMAL) {
                $newValue = 'Normal';
            } else {
                $newValue = 'High';
            }

            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }
        if ($request->status != $params['status']) {
            $changeField = 'Status';
            $oldValue = $request->status;
            $newValue = $params['status'];

            if ($oldValue == RequestStatusEnum::REQUEST_STATUS_OPEN) {
                $oldValue = 'Open';
            } elseif ($oldValue == RequestStatusEnum::REQUEST_STATUS_IN_PROGRESS) {
                $oldValue = 'In Progress';
            } else {
                $oldValue = 'Closed';
            }

            if ($newValue == RequestStatusEnum::REQUEST_STATUS_OPEN) {
                $newValue = 'Open';
            } elseif ($newValue == RequestStatusEnum::REQUEST_STATUS_IN_PROGRESS) {
                $newValue = 'In Progress';
            } else {
                $newValue = 'Closed';
            }

            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }
        if ($request->person_in_charge != $params['person_in_charge']) {
            $changeField = 'Assignee';
            $oldValue = User::find($request->person_in_charge)->name;
            $newValue = User::find($params['person_in_charge'])->name;
            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }
        if ($request->category_id != $params['category_id']) {
            $changeField = 'Category';
            $oldValue = Category::find($request->category_id)->name;
            $newValue = Category::find($params['category_id'])->name;
            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }
        if ($request->due_date != $params['due_date']) {
            $changeField = 'Due date';
            $oldValue = $request->due_date;
            $newValue = $params['due_date'];
            $change[$changeField] = array(
                'oldValue' => $oldValue,
                'newValue' => $newValue
            );
        }

        foreach ($change as $key => $val) {
            DB::table('history_details')->insert([
                ['history_id' => $history->id,
                'change_field' => $key,
                'old_value' => $change[$key]['oldValue'],
                'new_value' => $change[$key]['newValue']],
            ]);
        }
    }

    public function getDivisionManager($id)
    {
        $author = User::where('users.id', '=', $id)->first();
        $userTPB = User::where('users.department_id', $author->department_id)
        ->where('users.role_id', RoleEnum::ROLE_QUAN_LY_BO_PHAN)
        ->first();
        return $userTPB->id;
    }
}
