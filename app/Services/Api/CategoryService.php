<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Enums\CategoryStatusEnum;
use App\Models\Category;
use App\Models\User;
use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Model;

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
    public function search($key)
    {
        return [
            'data' => $this->categoryRepository->search($key)
        ];
    }
    public function store($params)
    {
        if ($params) {
            if ($params['name']) {
                $checkName = Category::where('name', '=', $params['name'])->get();
                if ($checkName->count()) {
                    return [
                        'message' => 'Da co category nay'
                    ];
                }
                $userId = User::findOrFail($params['user_id']);
                if ($userId->status == 0) {
                    return [
                        'message' => 'User chua duoc active',
                    ];
                } else {
                    $cate = new Category();
                    $cate->name = $params['name'];
                    $cate->status = CategoryStatusEnum::CATEGORY_ACTIVE_STATUS;
                    $cate->save();
                    $cate->users()->attach($params['user_id']);
                    return [
                        'message' => 'Them category thanh cong'
                    ];
                }
            } else {
                return [
                    'message' => 'Them category khong thanh cong'
                ];
            }
        }
    }
}
