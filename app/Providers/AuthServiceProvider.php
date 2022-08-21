<?php

namespace App\Providers;

use App\Enum\Role;
use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//         Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->is_admin) {
                return true;
            }
        });

        Gate::define('edit-product', [ProductPolicy::class, 'viewAny']);

        Gate::define('edit-order', function ($user) {
            return $user->hasRole(Role::SUPPORT) || $user->hasRole(Role::STOCK);
        });

        Gate::define('edit-shipping', function($user) {
            return $user->hasRole(Role::STOCK);
        });

        Gate::define('edit-invoice', function ($user) {
            return $user->hasRole(Role::SUPPORT);
        });

        Gate::define('edit-user', function ($user) {
            return $user->hasRole(Role::SUPPORT);
        });
    }
}
