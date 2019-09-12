<?php

namespace Yjtec\Cas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Support\Facades\Auth;
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Validator::resolver(function($translator, $data, $rules, $messages){
        //     return new TicketValidator($translator, $data, $rules, $messages);
        // });
        Auth::extend('cas',function($app,$name,array $config){
            return new CasGuard(
                Auth::createUserProvider($config['provider']),
                $this->app['request']
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cas', function ($app) {
            $cas = new Cas(config('cas'));
            return $cas;
        });
    }
}
