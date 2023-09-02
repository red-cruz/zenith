<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can create a model.
     */
    public function create(User $user, Shop $shop): Response
    {
        return $user->id === $shop->user_id
          ? Response::allow()
          : Response::deny('You can\'t add a product to this shop.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): Response
    {
        $shop = Shop::find($product->shop_id);
        return $user->id === $shop->user_id
          ? Response::allow()
          : Response::deny('You don\'t own this product.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): Response
    {
        $shop = Shop::find($product->shop_id);
        return $user->id === $shop->user_id
            ? Response::allow()
            : Response::deny('You don\'t own this product.');
    }
}
