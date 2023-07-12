<?php

namespace App\Providers;

use App\Contracts\AuthOTPModelInterface;
use App\Contracts\AuthOTPModuleInterface;
use App\Models\AuthOTP;
use App\Modules\AuthOTPModule;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthOTPServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthOTPModuleInterface::class, AuthOTPModule::class);
        $this->app->bind(AuthOTPModelInterface::class, AuthOTP::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addMinutes(2)); // Set the expiration time to 2 minutes
    }
}
