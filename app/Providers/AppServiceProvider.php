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
        
        // Dynamic Google Calendar Config from DB
        try {
            $googleCalendarId = \App\Models\Setting::get('google_calendar_id');
            $googleClientId = \App\Models\Setting::get('google_client_id');
            $googleClientSecret = \App\Models\Setting::get('google_client_secret');
            $googleRefreshToken = \App\Models\Setting::get('google_refresh_token');

            if ($googleCalendarId && $googleClientId && $googleClientSecret && $googleRefreshToken) {
                config(['google-calendar.default_auth_profile' => 'oauth']);
                config(['google-calendar.calendar_id' => $googleCalendarId]);
                
                // Construct credentials array (Google Client accepts array too)
                config(['google-calendar.auth_profiles.oauth.credentials_json' => [
                    'web' => [
                        'client_id' => $googleClientId,
                        'client_secret' => $googleClientSecret,
                        'redirect_uris' => ['https://developers.google.com/oauthplayground'],
                        'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                        'token_uri' => 'https://oauth2.googleapis.com/token',
                    ]
                ]]);

                config(['google-calendar.auth_profiles.oauth.token_json' => [
                    'access_token' => 'placeholder', 
                    'refresh_token' => $googleRefreshToken,
                    'token_type' => 'Bearer',
                    'expires_in' => 3599,
                    'created' => time(),
                ]]);
            }
        } catch (\Exception $e) {
            // Setup table might not exist yet during migration
        }
    }
}
