<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SelcomService
{
    protected $vendorId;
    protected $apiKey;
    protected $apiSecret;
    protected $isLive;
    protected $baseUrl;

    public function __construct()
    {
        $this->vendorId = config('selcom.vendor');
        $this->apiKey = config('selcom.key');
        $this->apiSecret = config('selcom.secret');
        $this->isLive = config('selcom.live', false);
        
        // Set base URL based on live status
        $this->baseUrl = $this->isLive 
            ? 'https://apigw.selcommobile.com/v1'
            : 'https://apigw.selcommobile.com/v1';
    }

    /**
     * Create checkout order
     */
    public function checkout(array $data)
    {
        try {
            // Set timezone for timestamp
            date_default_timezone_set('Africa/Dar_es_Salaam');
            
            $orderId = $data['transaction_id'] ?? 'COYZON-' . time() . '-' . rand(1000, 9999);
            
            // Build payload matching Selcom package format
            $payload = [
                'vendor' => $this->vendorId,
                'order_id' => $orderId,
                'buyer_email' => $data['email'],
                'buyer_name' => $data['name'],
                'buyer_phone' => $data['phone'],
                'amount' => (int) $data['amount'],
                'currency' => $data['currency'] ?? 'TZS',
                'redirect_url' => base64_encode(config('selcom.redirect_url') ?? route('selcom.redirect')),
                'cancel_url' => base64_encode(config('selcom.cancel_url') ?? route('selcom.cancel')),
                'webhook' => base64_encode(route('selcom.checkout-callback')),
                'no_of_items' => 1,
                'expiry' => config('selcom.expiry', 60),
                'header_colour' => config('selcom.colors.header', '#1a73e8'),
                'link_colour' => config('selcom.colors.link', '#000000'),
                'button_colour' => config('selcom.colors.button', '#1a73e8'),
            ];

            // Generate timestamp
            $timestamp = date('c');
            
            // Generate digest - timestamp first, then all data fields
            $digest = $this->generateDigest($payload, $timestamp);
            
            // Signed fields are ALL keys from payload
            $signedFields = implode(',', array_keys($payload));

            // Configure HTTP client with SSL options
            $httpClient = Http::withOptions([
                'verify' => env('SELCOM_VERIFY_SSL', false), // Disable SSL verification for Windows/local by default
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => env('SELCOM_VERIFY_SSL', false),
                    CURLOPT_SSL_VERIFYHOST => env('SELCOM_VERIFY_SSL', false) ? 2 : 0,
                    CURLOPT_TIMEOUT => 30,
                ],
            ]);

            $response = $httpClient->withHeaders([
                'Content-type' => 'application/json;charset="utf-8"',
                'Accept' => 'application/json',
                'Authorization' => 'SELCOM ' . base64_encode($this->apiKey),
                'Digest-Method' => 'HS256',
                'Digest' => $digest,
                'Signed-Fields' => $signedFields,
                'Cache-Control' => 'no-cache',
                'Timestamp' => $timestamp,
            ])->post($this->baseUrl . '/checkout/create-order-minimal', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Selcom checkout failed', [
                'status' => $response->status(),
                'response' => $response->body(),
                'payload' => $payload,
            ]);

            throw new \Exception('Selcom API error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Selcom checkout exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Create card checkout order
     */
    public function cardCheckout(array $data)
    {
        try {
            // Set timezone for timestamp
            date_default_timezone_set('Africa/Dar_es_Salaam');
            
            $orderId = $data['transaction_id'] ?? 'COYZON-' . time() . '-' . rand(1000, 9999);
            
            // Build payload for card checkout (create-order endpoint)
            $payload = [
                'vendor' => $this->vendorId,
                'order_id' => $orderId,
                'buyer_email' => $data['email'],
                'buyer_name' => $data['name'],
                'buyer_phone' => $data['phone'],
                'amount' => (int) $data['amount'],
                'currency' => $data['currency'] ?? 'TZS',
                'redirect_url' => base64_encode(config('selcom.redirect_url') ?? route('selcom.redirect')),
                'cancel_url' => base64_encode(config('selcom.cancel_url') ?? route('selcom.cancel')),
                'webhook' => base64_encode(route('selcom.checkout-callback')),
                'no_of_items' => 1,
                'expiry' => config('selcom.expiry', 60),
                'payment_methods' => 'ALL',
                'header_colour' => config('selcom.colors.header', '#1a73e8'),
                'link_colour' => config('selcom.colors.link', '#000000'),
                'button_colour' => config('selcom.colors.button', '#1a73e8'),
            ];
            
            // Add billing information if provided
            if (isset($data['address'])) {
                $nameParts = explode(' ', $data['name'], 2);
                $payload['billing.firstname'] = $nameParts[0] ?? $data['name'];
                $payload['billing.lastname'] = $nameParts[1] ?? '';
                $payload['billing.address_1'] = $data['address'];
                $payload['billing.city'] = $data['city'] ?? 'Dar Es Salaam';
                $payload['billing.state_or_region'] = $data['state'] ?? 'Dar Es Salaam';
                $payload['billing.postcode_or_pobox'] = $data['postcode'] ?? '';
                $payload['billing.country'] = $data['country_code'] ?? 'TZ';
                $payload['billing.phone'] = $data['phone'];
            }

            // Generate timestamp
            $timestamp = date('c');
            
            // Generate digest - timestamp first, then all data fields
            $digest = $this->generateDigest($payload, $timestamp);
            
            // Signed fields are ALL keys from payload
            $signedFields = implode(',', array_keys($payload));

            // Configure HTTP client with SSL options
            $httpClient = Http::withOptions([
                'verify' => env('SELCOM_VERIFY_SSL', false),
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => env('SELCOM_VERIFY_SSL', false),
                    CURLOPT_SSL_VERIFYHOST => env('SELCOM_VERIFY_SSL', false) ? 2 : 0,
                    CURLOPT_TIMEOUT => 30,
                ],
            ]);

            $response = $httpClient->withHeaders([
                'Content-type' => 'application/json;charset="utf-8"',
                'Accept' => 'application/json',
                'Authorization' => 'SELCOM ' . base64_encode($this->apiKey),
                'Digest-Method' => 'HS256',
                'Digest' => $digest,
                'Signed-Fields' => $signedFields,
                'Cache-Control' => 'no-cache',
                'Timestamp' => $timestamp,
            ])->post($this->baseUrl . '/checkout/create-order', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Selcom card checkout failed', [
                'status' => $response->status(),
                'response' => $response->body(),
                'payload' => $payload,
            ]);

            throw new \Exception('Selcom API error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Selcom card checkout exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Generate digest for Selcom API using HMAC-SHA256
     * Matches Selcom package implementation exactly
     */
    protected function generateDigest(array $data, string $timestamp): string
    {
        // Start with timestamp
        $signData = "timestamp=$timestamp";
        
        // Add all data fields in order
        if (count($data)) {
            foreach ($data as $key => $value) {
                $signData .= "&$key=$value";
            }
        }
        
        // Generate HMAC-SHA256 hash
        $hmac = hash_hmac('sha256', $signData, $this->apiSecret, true);
        
        // Base64 encode the hash
        return base64_encode($hmac);
    }
}
