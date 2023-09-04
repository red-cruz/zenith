<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Access\Response;

class UserAddressPolicy
{
    /**
       * Determine whether the user can view the model.
       */
    public function view(User $user, UserAddress $userAddress): Response
    {
      return $user->id === $userAddress->user_id
        ? Response::allow()
        : Response::deny('You don\'t have access to this address.');
    }

    public function update(User $user, UserAddress $userAddress): Response
    {
        return $user->id === $userAddress->user_id
          ? Response::allow()
          : Response::deny('You don\'t have access to this address.');
    }

    public function delete(User $user, UserAddress $userAddress): Response
    {
        return $user->id === $userAddress->user_id
          ? Response::allow()
          : Response::deny('You don\'t have access to this address.');
    }
}
