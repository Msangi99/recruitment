<?php

namespace App\Services;

use App\Models\AzamPesaSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AzamPayService
{
    protected $baseUrl;
    protected $authBaseUrl;
    protected $appName;
    protected $clientId;
    protected $clientSecret;
    protected $token;
    protected $environment;

    public function __construct()
    {
        $dbSettings = Schema::hasTable('azampesa_settings') ? AzamPesaSetting::first() : null;

        $mode = $dbSettings?->mode ?? config('azampay.environment', 'sandbox');
        $this->environment = $mode === 'live' ? 'production' : $mode;
        $this->baseUrl = config('azampay.urls.' . $this->environment);
        $this->authBaseUrl = config('azampay.auth_urls.' . $this->environment);
        $this->appName = $dbSettings?->app_name ?: config('azampay.app_name');
        $this->clientId = $dbSettings?->client_id ?: config('azampay.client_id');
        $this->clientSecret = $dbSettings?->secret_id ?: config('azampay.client_secret');
        $this->token = $dbSettings?->token ?: config('azampay.token');
    }

    /**
     * Get access token
     */
    public function getAccessToken()
    {
        if ($this->token) {
            return $this->token;
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->authBaseUrl . '/AppRegistration/GenerateToken', [
                'appName' => $this->appName,
                'clientId' => $this->clientId,
                'clientSecret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['accessToken'] ?? null;
            }

            Log::error('AzamPay token request failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('AzamPay token exception', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Mobile Checkout
     * 
     * @param array $data
     * @return array|null
     */
    public function mobileCheckout(array $data)
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            throw new \Exception('Failed to obtain AzamPay access token');
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->baseUrl . '/azampay/mno/checkout', [
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'TZS',
                'accountNumber' => $data['accountNumber'],
                'externalId' => $data['externalId'] ?? uniqid('COYZON-'),
                'provider' => $data['provider'] ?? 'Mpesa',
                'additionalProperties' => $data['additionalProperties'] ?? [],
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('AzamPay mobile checkout failed', [
                'status' => $response->status(),
                'response' => $response->body(),
                'data' => $data,
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('AzamPay mobile checkout exception', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Bank Checkout
     * 
     * @param array $data
     * @return array|null
     */
    public function bankCheckout(array $data)
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            throw new \Exception('Failed to obtain AzamPay access token');
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->baseUrl . '/azampay/bank/checkout', [
                'amount' => $data['amount'],
                'currencyCode' => $data['currency'] ?? 'TZS',
                'merchantAccountNumber' => $data['merchantAccountNumber'],
                'merchantMobileNumber' => $data['merchantMobileNumber'],
                'merchantName' => $data['merchantName'] ?? $this->appName,
                'otp' => $data['otp'],
                'provider' => $data['provider'],
                'referenceId' => $data['referenceId'] ?? uniqid('COYZON-'),
                'additionalProperties' => $data['additionalProperties'] ?? [],
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('AzamPay bank checkout failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('AzamPay bank checkout exception', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Card Checkout
     * 
     * @param array $data
     * @return array|null
     */
    public function cardCheckout(array $data)
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            throw new \Exception('Failed to obtain AzamPay access token');
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->baseUrl . '/azampay/card/checkout', [
                'amount' => $data['amount'],
                'currencyCode' => $data['currency'] ?? 'TZS',
                'cardNumber' => $data['cardNumber'],
                'cardHolderName' => $data['cardHolderName'],
                'cardExpiry' => $data['cardExpiry'],
                'cardCvv' => $data['cardCvv'],
                'externalId' => $data['externalId'] ?? uniqid('COYZON-'),
                'additionalProperties' => $data['additionalProperties'] ?? [],
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('AzamPay card checkout failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('AzamPay card checkout exception', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Verify Payment Status
     * 
     * @param string $externalId
     * @return array|null
     */
    public function verifyPayment(string $externalId)
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            throw new \Exception('Failed to obtain AzamPay access token');
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->baseUrl . '/azampay/transaction/query', [
                'externalId' => $externalId,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('AzamPay verify payment exception', [
                'message' => $e->getMessage(),
                'externalId' => $externalId,
            ]);
            return null;
        }
    }

    /**
     * Fetch the RSA public key from AzamPay for webhook signature verification
     * The key is cached for 24 hours to avoid excessive API calls
     */
    public function getPublicKey()
    {
        return Cache::remember('azampay_public_key', 3600 * 24, function () {
            $token = $this->getAccessToken();

            if (!$token) {
                Log::error('AzamPay: Cannot fetch public key, token missing');
                return null;
            }

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])->get($this->baseUrl . '/azampay/v1/public-key', [
                    'format' => 'Pem',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['publicKey'])) {
                        // Clean up the PEM key - ensure proper line breaks
                        $pem = $data['publicKey'];
                        $pem = str_replace('\n', "\n", $pem);
                        return $pem;
                    }
                }

                Log::error('AzamPay public key fetch failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return null;
            } catch (\Exception $e) {
                Log::error('AzamPay public key fetch exception', [
                    'message' => $e->getMessage(),
                ]);
                return null;
            }
        });
    }

    /**
     * Verify the RSA signature of a webhook callback
     * 
     * Signature is computed over: {utilityref}{externalreference}{transactionstatus}{operator}
     * 
     * @param string $utilityref Partner's reference
     * @param string $externalreference AzamPay's reference
     * @param string $transactionstatus Transaction status
     * @param string $operator Payment operator
     * @param string $signatureBase64 Base64-encoded RSA signature
     * @return bool
     */
    public function verifyWebhookSignature(
        string $utilityref,
        string $externalreference,
        string $transactionstatus,
        string $operator,
        string $signatureBase64
    ): bool {
        try {
            $publicKey = $this->getPublicKey();

            if (!$publicKey) {
                Log::warning('AzamPay webhook: Public key not available for signature verification');
                return false;
            }

            $dataToVerify = $utilityref . $externalreference . $transactionstatus . $operator;
            $signature = base64_decode($signatureBase64, true);

            if ($signature === false) {
                Log::warning('AzamPay webhook: Invalid base64 signature');
                return false;
            }

            $result = openssl_verify(
                $dataToVerify,
                $signature,
                $publicKey,
                OPENSSL_ALGO_SHA256
            );

            if ($result !== 1) {
                Log::warning('AzamPay webhook: Signature verification failed', [
                    'data_to_verify' => $dataToVerify,
                    'result' => $result,
                ]);
            }

            return $result === 1;
        } catch (\Exception $e) {
            Log::error('AzamPay webhook signature verification exception', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
