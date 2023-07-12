<?php

namespace App\Providers;

use App\Contracts\IPTrackingModelInterface;
use App\Contracts\IPTrackingModuleInterface;
use App\Models\IPTracking;
use App\Modules\IPTrackingModule;
use Carbon\Laravel\ServiceProvider;

class TrackingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPTrackingModuleInterface::class, IPTrackingModule::class);
        $this->app->bind(IPTrackingModelInterface::class, IPTracking::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
