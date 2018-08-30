<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Status::class => \App\Policies\StatusPolicy::class,
        \App\Models\User::class   =>  \App\Policies\UserPolicy::class

    ];


    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
