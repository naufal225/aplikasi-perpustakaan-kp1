<?php

namespace App\Providers;

use App\Models\Members;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        Gate::define(ability: "admin", callback: function(User $user) {
            return Auth::user()->admin == 1 || Auth::user()->admin == true;
        });

        Gate::define("member", function(Members $members) {
            return Auth::guard('member')->check();
        });

        Paginator::useBootstrapFive();
    }
}
