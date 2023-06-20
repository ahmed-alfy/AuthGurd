<?php

namespace App\Providers;

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\Auth\WorkerAuthController;

use App\Interface\AuthInterface;
use App\Interface\PostInterface;
use App\Repositry\AuthRepositry;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Worker;
use App\Repositry\PostRepositry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //bind AuthInterface to AuthRepositry with model => Admin and admin guard

        $this->app->when(AdminAuthController::class)
        ->needs(AuthInterface::class)
        ->give(function(){
            return new AuthRepositry(Admin::class,'admin');
        });


        //bind AuthInterface to AuthRepositry with model => Worker and worker guard

        $this->app->when(WorkerAuthController::class)
        ->needs(AuthInterface::class)
        ->give(function(){
            return new AuthRepositry(Worker::class,'worker');
        });

        //bind AuthInterface to AuthRepositry with model => Clint and client guard
         $this->app->when(ClientAuthController::class)
        ->needs(AuthInterface::class)
        ->give(function(){
            return new AuthRepositry(Client::class,'client');
        });


        // bind the PostInterface to the PostRepositry ;

        $this->app->bind(PostInterface::class,PostRepositry::class);    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
