<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; // harus ini
use Illuminate\Support\Facades\Gate;
use App\Models\Permission;


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
        $this->registerPolicies();

        // Mendefinisikan gate untuk semua permission di database
        foreach (Permission::all() as $permission) {
            Gate::define($permission->name, fn($user) => $user->can($permission->name));
        }
    }
}
