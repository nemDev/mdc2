<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
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
        Paginator::defaultView('vendor.pagination.bootstrap-5');
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

        Gate::define('can-import', function (User $user){
            $importTypes = Config::get('import_types');
            $allowedImportTypes = getAllowedImportTypes($user->permissions()->pluck('name')->toArray(), $importTypes);
            if(count($allowedImportTypes) > 0){
                return true;
            }
            return false;
        });

    }
}
