<?php

namespace App\Policies;

use App\Models\Rate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view rates.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Rate $rate): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view this rate.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to add rates.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rate $rate): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to edit this rate.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rate $rate): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to delete this rate.');
    }
}
