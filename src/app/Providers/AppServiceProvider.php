<?php

namespace App\Providers;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
