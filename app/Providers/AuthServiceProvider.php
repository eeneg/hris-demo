<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdministrator', function($user){
            return $user->role == 'Administrator';
        });

        Gate::define('isOfficeUser', function($user){
            return $user->role == 'Office User';
        });

        Gate::define('isAuthor', function($user){
            return $user->role == 'Author';
        });

        Gate::define('isAdministratorORAuthor', function($user){
            return $user->role == 'Administrator' || $user->role == 'Author';
        });

        Gate::define('employee', function($user){
            return !$user->role;
        });

        Passport::routes();
    }
}
