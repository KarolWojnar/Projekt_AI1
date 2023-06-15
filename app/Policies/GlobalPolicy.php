<?php

namespace App\Policies;

use App\Models\User;

class GlobalPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if ($user->isAdmin) {
            return true;
        }
    }
}
