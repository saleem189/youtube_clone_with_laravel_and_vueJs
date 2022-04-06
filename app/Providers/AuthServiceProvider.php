<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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
    
        // $this->registerPolicies();
        // /**
        // * only admin user and channel owner user can create 
        // */
        // Gate::define('channel_owner_or_admin', function($user){
        //     return $user->is_admin || $user->is_channel_owner;
        // });

        
    }
}
