<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Project;
use App\Models\User;
use App\Models\Beneficiary;
use App\Models\Location;
use App\Models\Donation;
use App\Policies\ProjectPolicy;
use App\Policies\UserPolicy;
use App\Policies\BeneficiaryPolicy;
use App\Policies\LocationPolicy;
use App\Policies\DonationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        User::class => UserPolicy::class,
        Beneficiary::class => BeneficiaryPolicy::class,
        Location::class => LocationPolicy::class,
        Donation::class => DonationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate especial para super-admin: permitir todo
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });
    }
}