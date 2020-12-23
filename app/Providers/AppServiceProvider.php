<?php

namespace App\Providers;

use App\Repositories\CashRegisterRepository;
use App\Repositories\CashRegisterRepositoryInterface;
use App\Services\CreateCashRegisterService;
use App\Services\CreateCashRegisterServiceInterface;
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
        $this->app->bind(CashRegisterRepositoryInterface::class, CashRegisterRepository::class);
        $this->app->bind(CreateCashRegisterServiceInterface::class, CreateCashRegisterService::class);
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
