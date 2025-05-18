<?php

namespace App\Providers;

use App\Services\Services\AdminService;
use App\Services\Services\CategoryService;
use App\Services\Services\ItemService;
use App\Services\Services\ItemTypeService;
use App\Services\Services\ProductService;
use App\Services\Services\SizeService;
use App\Services\Services\UserService;
use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\BranchInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('AdminService', function () {
            return new AdminService;
        });
        $this->app->bind('SizeService', function () {
            return new SizeService;
        });
        $this->app->bind('ItemTypeService', function () {
            return new ItemTypeService;
        });
        $this->app->bind('ItemService', function () {
            return new ItemService;
        });
        $this->app->bind('ProductService', function () {
            return new ProductService;
        });
        $this->app->bind('UserService', function () {
            return new UserService;
        });

        $this->app->bind(
            'App\Services\Contracts\BranchInterface',
            'App\Repositories\BranchRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\MainSettingInterface',
            'App\Repositories\MainSettingRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\SliderInterface',
            'App\Repositories\SliderRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\ExtraInterface',
            'App\Repositories\ExtraRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\TypeInterface',
            'App\Repositories\TypeRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\CategoryInterface',
            'App\Repositories\CategoryRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\ProductInterface',
            'App\Repositories\ProductRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\ManagerInterface',
            'App\Repositories\ManagerRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\CouponInterface',
            'App\Repositories\CouponRepository'
        );

        $this->app->bind(
            'App\Services\Contracts\OrderInterface',
            'App\Repositories\OrderRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\AdminUserInterface',
            'App\Repositories\AdminUserRepository'
        );
        $this->app->bind(
            'App\Services\Contracts\PackageInterface',
            'App\Repositories\PackageRepository'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
