<?php

namespace Gadhyare\HornPay\Drivers;

use Gadhyare\HornPay\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class EdahabDriver implements PaymentGatewayInterface
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function purchase(array $payload): mixed
    {
        $phone = $payload['phone'];

        // Remove any leading 0 or non-numeric characters if needed
        $phone = preg_replace('/[^0-9]/', '', $phone);

        $params = [
            'apiKey' => $this->config['api_key'],
            'edahabNumber' => $phone,
            'amount' => $payload['amount'],
            'agentCode' => $this->config['agent_code'],
            'returnUrl' => $payload['return_url'] ?? $this->config['return_url'],
        ];

        $json = json_encode($params, JSON_UNESCAPED_SLASHES);
        $hashed = hash('SHA256', $json . $this->config['secret_key']);
        $url = $this->config['base_url'] . "?hash=" . $hashed;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $params);

        if ($response->failed()) {
            throw new Exception("Edahab API request failed: " . $response->body());
        }

        $data = $response->json();

        if (($data['InvoiceStatus'] ?? '') !== 'Paid') {
            throw new Exception("Edahab Error: " . ($data['errorMessage'] ?? 'Invoice was not paid or communication failed'));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function verify(string $transactionId): mixed
    {
        // Edahab snippet doesn't show a specific verify endpoint, 
        // usually it depends on internal status or a specific query API.
        return ['status' => 'unknown', 'message' => 'Verification not implemented for Edahab yet.'];
    }

    /**
     * @inheritDoc
     */
    public function checkStatus(string $reference): mixed
    {
        // Placeholder for Edahab status check if available.
        return ['status' => 'unknown', 'message' => 'Status check not implemented for Edahab yet.'];
    }
}
