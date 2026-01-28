<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Configure Guzzle HTTP client globally for SSL handling
        $this->app->singleton(Client::class, function ($app) {
            $verifySsl = env('SELCOM_VERIFY_SSL', env('APP_ENV') === 'local' ? false : true);
            
            return new Client([
                'verify' => $verifySsl,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => $verifySsl,
                    CURLOPT_SSL_VERIFYHOST => $verifySsl ? 2 : 0,
                    CURLOPT_TIMEOUT => 30,
                ],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // Configure Laravel HTTP facade defaults
        Http::macro('selcom', function () {
            $verifySsl = env('SELCOM_VERIFY_SSL', env('APP_ENV') === 'local' ? false : true);
            
            return Http::withOptions([
                'verify' => $verifySsl,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => $verifySsl,
                    CURLOPT_SSL_VERIFYHOST => $verifySsl ? 2 : 0,
                    CURLOPT_TIMEOUT => 30,
                ],
            ]);
        });
        
        });
    }
}
