<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Academics' => 'App\Policies\AcademicsPolicy',
        'App\InvolvementLog' => 'App\Policies\InvolvementLogPolicy',
        'App\ServiceLog' => 'App\Policies\ServiceLogPolicy',
        'App\Event' => 'App\Policies\EventPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies();

        $gate->before(function ($user) {
            if ($user->isAdmin() || $user->id === $user->organization->owner_id) {
                return true;
            }
        });
    }
}
