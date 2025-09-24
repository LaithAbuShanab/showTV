<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Show;
use App\Models\Tag;
use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\AdminPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\EpisodePolicy;
use App\Policies\SeasonPolicy;
use App\Policies\ShowPolicy;
use App\Policies\TagPolicy;
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
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Show::class, ShowPolicy::class);
        Gate::policy(Episode::class, EpisodePolicy::class);
        Gate::policy(Season::class, SeasonPolicy::class);
        Gate::policy(Admin::class, AdminPolicy::class);
    }
}
