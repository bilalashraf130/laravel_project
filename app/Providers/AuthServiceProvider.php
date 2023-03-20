<?php

namespace App\Providers;

use App\Gates\AdminGates;
use App\Models\Post;
use App\Models\UserNarrative;
use App\Policies\PostPolicy;
use App\Policies\UserNarrativePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
         'App\Models\Post' => 'App\Policies\PostPolicy',
        UserNarrative::class => UserNarrativePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//        Gate::define('isAdmin',function($user){
//            if($user->email === 'admin@gmail.com'){
//                return true;
//            } else {
//                return false;
//            }
//        });
        Gate::define('isAdmin',[AdminGates::class,'check_admin']);
    }
}
