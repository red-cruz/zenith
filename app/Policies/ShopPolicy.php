<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShopPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Shop::select('id')->where('user_id', $user->id)->first()
          ? Response::deny('You already have a shop.')
          : Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shop $shop): Response
    {
        return $user->id === $shop->user_id
          ? Response::allow()
          : Response::deny('You don\'t own this shop.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shop $shop): Response
    {
        return $user->id === $shop->user_id
          ? Response::allow('allowed')
          : Response::deny('You don\'t own this shop.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shop $shop): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shop $shop): bool
    {
        return true;
    }
}
