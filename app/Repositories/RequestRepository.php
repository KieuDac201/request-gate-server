<?php

namespace App\Repositories;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Models\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\QueryException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class RequestRepository extends BaseRepository implements RequestRepositoryInterface
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getList($params)
    {
        $data = $this->model
        ->join('categories', 'category_id', '=', 'categories.id')
        ->join('users', 'author_id', '=', 'users.id')
        ->select(
            'requests.id',
            'requests.name',
            'content',
            'priority',
            'requests.status',
            'author_id',
            'users.name as author_name',
            'person_in_charge',
            'category_id',
            'requests.created_at as create_time',
            'categories.name as category_name'
        )->addSelect(['person_in_charge_name' => User::select('name')
        ->whereColumn('person_in_charge', 'users.id')]);
        if (isset($params['myRequest'])) {
            $idUser = Auth::id();
            $data->where('requests.author_id', '=', $idUser);
            return $data;
        } else {
            if (isset($params['name_request'])) {
                $data->where('requests.name', 'like', '%'.$params['name_request'].'%');
            }
            if (isset($params['content'])) {
                $data->where('requests.content', 'like', '%'.$params['content'].'%');
            }
            if (isset($params['status'])) {
                $data->where('requests.status', '=', $params['status']);
            }
            if (isset($params['author'])) {
                $data->where('requests.author_id', '=', $params['author']);
            }
            if (isset($params['assign'])) {
                $data->where('requests.person_in_charge', '=', $params['assign']);
            }
            if (isset($params['category'])) {
                $data->where('requests.category_id', '=', $params['category']);
            }
            if (isset($params['date_create'])) {
                $data->whereDate('requests.created_at', '=', $params['date_create']);
            }
            return $data;
        }
    }
}
