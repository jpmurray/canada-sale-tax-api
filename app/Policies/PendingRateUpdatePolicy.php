<?php

namespace App\Policies;

use App\Models\PendingRateUpdate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PendingRateUpdatePolicy
{
    /**
     * Determine whether the user can view any pending rate updates.
     * Only admins can view all pending updates.
     */
    public function viewAny(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to view pending rate updates.');
    }

    /**
     * Determine whether the user can view the pending rate update.
     * Users can view their own submissions, admins can view all.
     */
    public function view(User $user, PendingRateUpdate $pendingRateUpdate): Response
    {
        if ($user->is_admin || $user->id === $pendingRateUpdate->user_id) {
            return Response::allow();
        }

        return Response::deny('You are not authorized to view this pending rate update.');
    }

    /**
     * Determine whether the user can create pending rate updates.
     * Any authenticated user can submit rate update proposals.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can approve or reject pending rate updates.
     * Only admins can approve or reject.
     */
    public function review(User $user, PendingRateUpdate $pendingRateUpdate): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny('You are not authorized to review pending rate updates.');
    }
}
