<?php

namespace App\Policies;

use App\Models\Tim;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view teams
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Tim $tim): bool
    {
        return true; // Everyone can view team details
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tim $tim): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tim $tim): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can set a team as the main team.
     */
    public function setMainTeam(User $user, Tim $tim): bool
    {
        return $user->isAdmin();
    }
}