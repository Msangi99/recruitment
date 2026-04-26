<?php

namespace App\Providers;

use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

        if (Schema::hasTable('settings') && Setting::isMailConfigFromDatabaseEnabled()) {
            $mailer = Setting::get('mail_mailer', 'smtp') ?: 'smtp';
            if (! is_string($mailer)) {
                $mailer = 'smtp';
            }
            config(['mail.default' => $mailer]);

            $host = Setting::get('mail_host') ?: config('mail.mailers.smtp.host', '127.0.0.1');
            $port = (int) (Setting::get('mail_port') ?: config('mail.mailers.smtp.port', 587));
            $user = Setting::get('mail_username');
            if (! is_string($user) || $user === '') {
                $user = config('mail.mailers.smtp.username');
            }
            $dbPass = Setting::getDecryptedMailPassword();
            $pass = is_string($dbPass) && $dbPass !== '' ? $dbPass : config('mail.mailers.smtp.password');

            $enc = Setting::get('mail_encryption', 'tls');
            $enc = is_string($enc) ? $enc : 'tls';
            if ($enc === '' || $enc === 'none') {
                $enc = null;
            }

            $fromAddr = Setting::get('mail_from_address') ?: config('mail.from.address', 'hello@example.com');
            $fromName = Setting::get('mail_from_name') ?: config('mail.from.name', 'Example');

            config([
                'mail.mailers.smtp' => array_merge(config('mail.mailers.smtp', []), [
                    'host' => is_string($host) ? $host : (string) $host,
                    'port' => $port,
                    'username' => is_string($user) ? $user : (string) $user,
                    'password' => $pass,
                    'encryption' => $enc,
                ]),
                'mail.from' => [
                    'address' => is_string($fromAddr) ? $fromAddr : (string) $fromAddr,
                    'name' => is_string($fromName) ? $fromName : (string) $fromName,
                ],
            ]);
        }
        
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
    }
}
