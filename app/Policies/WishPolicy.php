<?php

namespace App\Policies;

use App\User;
use App\Wish;
use Illuminate\Auth\Access\HandlesAuthorization;

class WishPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create wishes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the wish.
     *
     * @param  \App\User  $user
     * @param  \App\Wish  $wish
     * @return mixed
     */
    public function delete(User $user, Wish $wish)
    {
        return $wish->user_id == $user->id;
    }

    public function purchase(User $user, Wish $wish) {
        return $wish->purchased_by == null && $user->id != $wish->user_id;
    }

    public function unpurchase(User $user, Wish $wish) {
        return $user->id == $wish->purchased_by;
    }
}
