<?php

namespace App\Policies;

use App\Models\Usage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UsagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view usages.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Usage $usage): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view this usage.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to add usages.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Usage $usage): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to edit this usage.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Usage $usage): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to delete this usage.');
    }
}
