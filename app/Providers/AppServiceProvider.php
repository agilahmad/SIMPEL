<?php

namespace App\Providers;

use App\Models\{ Application, Incident, Pentest, User, Vulnerability, };
use App\Policies\{ ApplicationPolicy, IncidentPolicy, PentestPolicy, UserPolicy, VulnerabilityPolicy, };
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::before(function ($user, $ability) {
            if ($ability === 'uploadEvidence') {
            return null;
            }
            if ($user->isAdmin()) {
                return true;
            }
            return null;
        });

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Application::class, ApplicationPolicy::class);
        Gate::policy(Pentest::class, PentestPolicy::class);
        Gate::policy(Vulnerability::class, VulnerabilityPolicy::class);
        Gate::policy(Incident::class, IncidentPolicy::class);
    }
}
