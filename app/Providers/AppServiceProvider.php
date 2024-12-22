<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::define('have-permission', function (User $user, string $permission){
            $userPermissions = $user->permissions()->pluck('name')->toArray();
            if(in_array($permission, $userPermissions)){
                return true;
            }
            return false;
        });

        Gate::define('user-management', function (User $user){
            $userPermissions = $user->permissions()->pluck('name')->toArray();
            if(in_array('user-management', $userPermissions)){
                return true;
            }
            return false;
        });

    }
}
