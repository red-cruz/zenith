<?php

namespace App\Providers;

use App\Models\Cart;
use App\Policies\CartPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ShopPolicy;
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
        Gate::define('cart-delete', [CartPolicy::class, 'delete']);
        Gate::define('shop-create', [ShopPolicy::class, 'create']);
        Gate::define('shop-update', [ShopPolicy::class, 'update']);
        Gate::define('shop-delete', [ShopPolicy::class, 'delete']);
        Gate::define('product-create', [ProductPolicy::class, 'create']);
        Gate::define('product-update', [ProductPolicy::class, 'update']);
        Gate::define('product-delete', [ProductPolicy::class, 'delete']);
    }
}
