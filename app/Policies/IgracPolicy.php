<?php

namespace App\Policies;

use App\Models\Igrac;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IgracPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view players
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Igrac $igrac): bool
    {
        return true; // Everyone can view player details
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
    public function update(User $user, Igrac $igrac): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Igrac $igrac): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can update a club for this player.
     */
    public function updateClub(User $user, Igrac $igrac): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete a club from this player.
     */
    public function deleteClub(User $user, Igrac $igrac): bool
    {
        return $user->hasEditAccess();
    }
}