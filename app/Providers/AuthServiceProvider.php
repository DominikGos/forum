<?php

namespace App\Providers;

use App\Models\Topic;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class
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

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return route('password.reset.form', ['token' => $token]);
        });
    }
}
