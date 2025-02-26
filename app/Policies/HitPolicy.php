<?php

namespace App\Policies;

use App\Models\Hit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view hits.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hit $hit): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view this hit.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to add hits.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hit $hit): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to edit this hit.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hit $hit): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to delete this hit.');
    }
}
