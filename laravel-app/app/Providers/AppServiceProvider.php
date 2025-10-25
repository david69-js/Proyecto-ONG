<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // ==============================================
        // DIRECTIVAS BLADE PARA ROLES
        // ==============================================
        
        // @role('admin') - Verifica un rol específico
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        // @hasanyrole('admin', 'super-admin') - Verifica cualquiera de los roles
        Blade::if('hasanyrole', function (...$roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });

        // @anyrole('admin', 'super-admin') - Alias más corto
        Blade::if('anyrole', function (...$roles) {
            return auth()->check() && auth()->user()->hasAnyRole($roles);
        });

        // ==============================================
        // DIRECTIVAS BLADE PARA PERMISOS
        // ==============================================
        
        // @permission('users.view') - Verifica un permiso específico
        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        // @hasanypermission('users.view', 'users.edit') - Verifica cualquiera de los permisos
        Blade::if('hasanypermission', function (...$permissions) {
            return auth()->check() && auth()->user()->hasAnyPermission($permissions);
        });

        // @anypermission('users.view', 'users.edit') - Alias más corto
        Blade::if('anypermission', function (...$permissions) {
            return auth()->check() && auth()->user()->hasAnyPermission($permissions);
        });
    }
}