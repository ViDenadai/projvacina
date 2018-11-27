<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
use App\User;
use App\dose;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      /*  'App\Model' => 'App\Policies\ModelPolicy',*/
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        /*
        $gate->define('update-post', function(User $user, Post $post){
            return $user->id == $post->user_id;
        });
         */
        
        $permissions = Permission::with('roles')->get();
        foreach( $permissions as $permission )
        {
            $gate->define($permission->name, function(User $user) use ($permission){
                return $user->hasPermission($permission);
            });
        }

        $gate->before(function(User $user, $ability){
            // Caso o usuário seja adm, possui permissão para fazer qualquer coisa
            if ( $user->hasAnyRoles('adm') )
                return true;
            
        });
    }
}
