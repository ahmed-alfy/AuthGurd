<?php

namespace App\Providers;

use App\Interface\AuthInterface;
use App\Interface\PostInterface;
use App\Repositry\AuthRepositry;
use App\Repositry\PostRepositry;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Auth\AuthController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // bind AuthInterface to AuthRepositry with different guards deppending on the {guard} params of the route

        $this->app->when(AuthController::class)
        ->needs(AuthInterface::class)
        ->give(function(){
            $guard  = $this->app->request->route('guard');
            $model = ucfirst($guard);
            return new AuthRepositry("App\\Models\\$model","$guard");
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
