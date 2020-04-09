<?php

namespace App\Policies;

use App\User;
use App\MoneyRepository as Money;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoneyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view operation records.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the money.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->locked == false;
    }
}
