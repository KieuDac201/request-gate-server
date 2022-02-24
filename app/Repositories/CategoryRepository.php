<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
    public function search($key)
    {
        $query = Category::query();
        $params = $query->with('users:id,name,email')
            ->where('name', 'like', '%'.$key.'%')
            ->select('id', 'name', 'status')->get();
        return $params;
    }
    public function getList($params)
    {
        $params = Category::with('users:id,name,email')->select('id', 'name', 'status')->get();
        return $params;
    }
}
