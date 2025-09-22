<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // OBSERVER
        User::observe(UserObserver::class);

        // POLICY
        Gate::policy(User::class, UserPolicy::class);
    }
}
