<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         // Super Admin otomatis bisa semua
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        // Daftarkan permission lain
        $permissions = \App\Models\Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        }

        Blade::if('can', function ($permission) {
            $user = Auth::user();
            if (!$user) return false;

            // Jika Super Admin / admin, otomatis boleh semua
            if ($user->role && $user->role->name === 'admin') {
                return true;
            }

            return $user->hasPermission($permission);
        });
    }
}
