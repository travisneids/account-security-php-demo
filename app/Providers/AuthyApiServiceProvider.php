<?php

namespace App\Providers;

use Authy\AuthyApi;
use Illuminate\Support\ServiceProvider;

class AuthyApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $authyApiKey = env('TWILIO_AUTHY_API_KEY');
        $this->app->bind('Authy\AuthyApi', function() {
            return new AuthyApi(env('TWILIO_AUTHY_API_KEY'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
