<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AzamPayService
{
    protected $baseUrl;
    protected $appName;
    protected $clientId;
    protected $clientSecret;
    protected $token;
    protected $environment;

    public function __construct()
    {
        $this->environment = config('azampay.environment', 'sandbox');
        $this->baseUrl = config('azampay.urls.' . $this->environment);
        $this->appName = config('azampay.app_name');
        $this->clientId = config('azampay.client_id');
        $this->clientSecret = config('azampay.client_secret');
        $this->token = config('azampay.token');
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
            ])->post($this->baseUrl . '/appregistration/oauth2/token', [
                'appName' => $this->appName,
                'clientId' => $this->clientId,
                'clientSecret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['accessToken'] ?? null;
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
                'currencyCode' => $data['currency'] ?? 'TZS',
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
                'externalId' => $data['externalId'] ?? uniqid('COYZON-'),
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
}
