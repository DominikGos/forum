<?php

namespace App\Providers;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('delete-topic', function(User $user, Topic $topic) {
            return $user->id == $topic->user_id
                            ? Response::allow()
                            : Response::deny('You must be an administrator.');
        });

        Gate::define('update-topic', function(User $user, Topic $topic) {
            return $user->id == $topic->user_id;
        });

        Gate::define('update-profile', function(User $authenticated , User $user) {
            return $authenticated->id == $user->id
                                    ? Response::allow()
                                    : Response::deny('You must be an administrator.');
        });

    }
}
