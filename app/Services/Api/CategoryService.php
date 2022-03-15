<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Enums\CategoryStatusEnum;
use App\Enums\UserStatusEnum;
use App\Exceptions\QueryException;
use App\Models\Category;
use App\Models\User;
use App\Services\AbstractService;

class CategoryService extends AbstractService implements CategoryServiceInterface
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index($params)
    {
        return [
            'data' => $this->categoryRepository->getList($params)
        ];
    }
    public function store($params)
    {
        if ($params['name']) {
            $checkName = Category::where('name', '=', $params['name'])->get();
            if ($checkName->count()) {
                throw new QueryException('Da co category nay');
            }
            $users = User::findOrFail($params['user_id']);
            foreach ($users as $user) {
                $data = $user->status;
            }
            if ($data == UserStatusEnum::USER_DEACTIVE_STATUS) {
                   throw new QueryException('User chua duoc active');
            } else {
                $cate = new Category();
                $cate->name = $params['name'];
                $cate->status = CategoryStatusEnum::CATEGORY_ACTIVE_STATUS;
                $cate->save();
                $cate->users()->attach($params['user_id']);
                return [
                    'message' => 'Success',
                    'data' => [
                        'id' => $cate->id,
                        'name' => $cate->name,
                        'status' => $cate->status,
                        'users' => $this->categoryRepository->showNameUser($params['user_id'])
                    ]
                ];
            }
        }
    }
    public function update(Category $category, $params)
    {
        if ($params) {
            $users = User::findOrFail($params['user_id']);
            foreach ($users as $user) {
                $data = $user->status;
            }
            if ($data == UserStatusEnum::USER_DEACTIVE_STATUS) {
                throw new QueryException('User chua duoc active');
            } else {
                $cate = Category::findOrFail($category->id);
                if ($params['name'] != $cate->name) {
                    $nameCategory = Category::where('name', '=', $params['name'])->count();
                    if ($nameCategory > 0) {
                        throw new QueryException('This category name already exists');
                    }
                }
                $cate->name = $params['name'];
                $cate->status = $params['status'];
                $cate->save();
                $cate->users()->sync($params['user_id']);
                return [
                    'message' => 'Success',
                    'data' => [
                        'id' => $cate->id,
                        'name' => $cate->name,
                        'status' => $cate->status,
                        'users' => $this->categoryRepository->showNameUser($params['user_id'])
                    ]
                ];
            }
        }
    }

    public function find($params)
    {
        return [
            'data' => $this->categoryRepository->find($params),
        ];
    }
}
