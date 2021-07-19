<?php

namespace App\Providers;

use App\Step;
use App\User;
use App\Snippet;
use App\Policies\StepPolicy;
use App\Policies\UserPolicy;
use App\Policies\SnippetPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Snippet::class  => SnippetPolicy::class,
        Step::class     => StepPolicy::class,
        User::class     => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
