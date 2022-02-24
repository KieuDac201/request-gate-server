<?php

namespace App\Providers;

use App\Contracts\Services\Api\UserServiceInterface;
use App\Services\Api\UserService;
use App\Contracts\Services\Api\RoleServiceInterface;
use App\Services\Api\RoleService;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Services\Api\DepartmentService;
use Illuminate\Support\ServiceProvider;

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
