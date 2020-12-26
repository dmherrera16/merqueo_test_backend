<?php

namespace App\Providers;

use App\Repositories\CashRegisterRepository;
use App\Repositories\CashRegisterRepositoryInterface;
use App\Repositories\CreateMovementsRepository;
use App\Repositories\CreateMovementsRepositoryInterface;
use App\Repositories\ValidateCashRegisterRepositoryInterface;
use App\Repositories\ValidateCashRegisterRepository;
use App\Services\CreateCashRegisterService;
use App\Services\CreateCashRegisterServiceInterface;
use App\Services\CreateMovementService;
use App\Services\CreateMovementServiceInterface;
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
        $this->app->bind(CreateMovementsRepositoryInterface::class, CreateMovementsRepository::class);
        $this->app->bind(ValidateCashRegisterRepositoryInterface::class, ValidateCashRegisterRepository::class);
        $this->app->bind(CreateMovementServiceInterface::class, CreateMovementService::class);
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
