<?php

namespace App\Policies;

use App\Models\Selektor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelektorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view coaches
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Selektor $selektor): bool
    {
        return true; // Everyone can view coach details
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
    public function update(User $user, Selektor $selektor): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Selektor $selektor): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can add a mandate to this coach.
     */
    public function addMandat(User $user, Selektor $selektor): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete a mandate from this coach.
     */
    public function deleteMandat(User $user, Selektor $selektor): bool
    {
        return $user->hasEditAccess();
    }
}