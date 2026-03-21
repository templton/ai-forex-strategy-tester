<?php

namespace App\Providers;

use App\Contracts\Repository\Strategy\StrategyRepositoryInterface;
use App\Repository\Strategy\StrategyRepository;
use Components\Common\CommonComponent;
use Components\Common\Contracts\TimeInfo\TimeInfoInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TimeInfoInterface::class, CommonComponent::class);
        $this->app->bind(StrategyRepositoryInterface::class, StrategyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
