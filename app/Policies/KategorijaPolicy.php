<?php

namespace App\Policies;

use App\Models\Kategorija;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategorijaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view categories
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Kategorija $kategorija): bool
    {
        return true; // Everyone can view category details
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
    public function update(User $user, Kategorija $kategorija): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kategorija $kategorija): bool
    {
        return $user->hasEditAccess();
    }
}