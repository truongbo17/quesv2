<?php

namespace App\Providers;

use App\Service\PermissionGateAndPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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
        $permission = new PermissionGateAndPolicy();

        $permission->Category();
        $permission->Dashbroad();
        $permission->FileManager();
        $permission->Log();
        $permission->User();
        $permission->Role();
        $permission->Permission();
    }
}
