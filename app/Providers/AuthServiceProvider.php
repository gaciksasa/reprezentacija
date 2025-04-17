<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

// Models
use App\Models\Tim;
use App\Models\Igrac;
use App\Models\Utakmica;
use App\Models\Selektor;
use App\Models\Post;
use App\Models\Kategorija;
use App\Models\Sastav;
use App\Models\Gol;
use App\Models\Izmena;
use App\Models\Karton;
use App\Models\SelektorMandat;
use App\Models\ProtivnickiIgrac;
use App\Models\ProtivnickiSelektor;
use App\Models\ProtivnickiKarton;
use App\Models\ProtivnickaIzmena;
use App\Models\Stadion;
use App\Models\Takmicenje;
use App\Models\Sudija;

// Policies
use App\Policies\TimPolicy;
use App\Policies\IgracPolicy;
use App\Policies\UtakmicaPolicy;
use App\Policies\SelektorPolicy;
use App\Policies\PostPolicy;
use App\Policies\KategorijaPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Tim::class => TimPolicy::class,
        Igrac::class => IgracPolicy::class,
        Utakmica::class => UtakmicaPolicy::class,
        Selektor::class => SelektorPolicy::class,
        Post::class => PostPolicy::class,
        Kategorija::class => KategorijaPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register the policies
        $this->registerPolicies();

        // Define general gates for editing and administration
        Gate::define('edit', function (User $user) {
            return $user->hasEditAccess();
        });

        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        // Gates for related models that don't have their own policies
        Gate::define('manage-sastav', function (User $user, Sastav $sastav = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-gol', function (User $user, Gol $gol = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-izmena', function (User $user, Izmena $izmena = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-karton', function (User $user, Karton $karton = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-selektor-mandat', function (User $user, SelektorMandat $mandat = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-protivnicki-igrac', function (User $user, ProtivnickiIgrac $igrac = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-protivnicki-selektor', function (User $user, ProtivnickiSelektor $selektor = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-protivnicki-karton', function (User $user, ProtivnickiKarton $karton = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-protivnicka-izmena', function (User $user, ProtivnickaIzmena $izmena = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-stadion', function (User $user, Stadion $stadion = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-takmicenje', function (User $user, Takmicenje $takmicenje = null) {
            return $user->hasEditAccess();
        });

        Gate::define('manage-sudija', function (User $user, Sudija $sudija = null) {
            return $user->hasEditAccess();
        });
    }
}