<?php

namespace App\Policies;

use App\Models\Utakmica;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtakmicaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view matches
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Utakmica $utakmica): bool
    {
        return true; // Everyone can view match details
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Always allow admin users
        if ($user->isAdmin()) {
            return true;
        }
        
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Utakmica $utakmica): bool
    {   
        // Always allow admin users
        if ($user->isAdmin()) {
            return true;
        }

        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Utakmica $utakmica): bool
    {
        // Always allow admin users
        if ($user->isAdmin()) {
            return true;
        }
        
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can manage lineups for this match.
     */
    public function manageSastavi(User $user, Utakmica $utakmica): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can manage goals for this match.
     */
    public function manageGolovi(User $user, Utakmica $utakmica): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can manage substitutions for this match.
     */
    public function manageIzmene(User $user, Utakmica $utakmica): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can manage cards for this match.
     */
    public function manageKartoni(User $user, Utakmica $utakmica): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can manage opponent players for this match.
     */
    public function manageProtivnickiIgraci(User $user, Utakmica $utakmica): bool
    {
        return $user->hasEditAccess();
    }

    /**
     * Determine whether the user can manage opponent coaches for this match.
     */
    public function manageProtivnickiSelektori(User $user, Utakmica $utakmica): bool
    {
        return $user->hasEditAccess();
    }
}