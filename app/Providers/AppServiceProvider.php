<?php

namespace App\Providers;

use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Services\Api\CategoryService;
use App\Services\Api\UserService;
use App\Contracts\Services\Api\RoleServiceInterface;
use App\Services\Api\RoleService;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Services\Api\DepartmentService;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Services\Api\RequestService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\Api\CommentServiceInterface;
use App\Services\Api\CommentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $services = [
            [
                UserServiceInterface::class,
                UserService::class
            ],
            [
                RoleServiceInterface::class,
                RoleService::class
            ],
            [
                DepartmentServiceInterface::class,
                DepartmentService::class
            ],
            [
                CategoryServiceInterface::class,
                CategoryService::class
            ],
            [
                RequestServiceInterface::class,
                RequestService::class
            ],
            [
                CommentServiceInterface::class,
                CommentService::class
            ],
        ];
        foreach ($services as $service) {
            $this->app->bind(
                $service[0],
                $service[1]
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
