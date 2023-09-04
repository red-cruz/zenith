<?php

namespace App\Providers;

use App\Models\Cart;
use App\Policies\CartPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ShopPolicy;
use App\Policies\UserAddressPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
      Cart::class => CartPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // USER
        Gate::define('user-delete', [UserPolicy::class, 'delete']);

        // USER ADDRESS
        Gate::define('user-address-read', [UserAddressPolicy::class, 'view']);
        Gate::define('user-address-update', [UserAddressPolicy::class, 'update']);
        Gate::define('user-address-delete', [UserAddressPolicy::class, 'delete']);

        // CART
        Gate::define('cart-delete', [CartPolicy::class, 'delete']);

        // SHOP
        Gate::define('shop-create', [ShopPolicy::class, 'create']);
        Gate::define('shop-update', [ShopPolicy::class, 'update']);
        Gate::define('shop-delete', [ShopPolicy::class, 'delete']);

        // PRODUCT
        Gate::define('product-create', [ProductPolicy::class, 'create']);
        Gate::define('product-update', [ProductPolicy::class, 'update']);
        Gate::define('product-delete', [ProductPolicy::class, 'delete']);
    }
}
