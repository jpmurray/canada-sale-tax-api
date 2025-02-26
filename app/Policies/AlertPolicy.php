<?php

namespace App\Policies;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlertPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to do this.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Alert $alert): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to do this.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to do this.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Alert $alert): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to do this.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Alert $alert): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to do this.');
    }
}
