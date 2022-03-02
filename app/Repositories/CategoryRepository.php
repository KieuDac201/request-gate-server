<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use App\Models\User;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
    public function getList($params)
    {
        $query = Category::with('users:id,name')->select('id', 'name', 'status');
        if (isset($params)) {
            $query->where('name', 'like', '%'.$params.'%');
        }
        $data = $query->get();
        return $data;
    }
    public function showNameUser($params)
    {
        $users = User::find($params);
        foreach ($users as $data) {
            $user[] = [
                    "id"=>$data->id,
                    "name"=>$data->name
                ] ;
        }
        return $user ;
    }
    public function find($id, $columns = ['*'])
    {
        $category = $this->model->findOrFail($id, $columns);
        return $category->load(['users:id,name']);
    }
}
