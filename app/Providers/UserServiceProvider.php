<?php

namespace App\Providers;

use App\Contracts\UserModelInterface;
use App\Contracts\UserModuleInterface;
use App\Models\User;
use App\Modules\UserModule;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserModuleInterface::class, UserModule::class);
        $this->app->bind(UserModelInterface::class, User::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
