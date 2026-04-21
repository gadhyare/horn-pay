<?php

namespace Gadhyare\HornPay\Drivers;

use Gadhyare\HornPay\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class WaafiDriver implements PaymentGatewayInterface
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
        $uuid = date('Ymdhis');
        $phone = $payload['account_no'];

        // Prepend 252 if not present
        if (!str_starts_with($phone, '252')) {
            $phone = '252' . $phone;
        }

        $response = Http::post($this->config['base_url'], [
            'schemaVersion' => '1.0',
            'requestId' => $uuid,
            'timestamp' => date('Y-m-d H:i:s'),
            'channelName' => 'WEB',
            'serviceName' => 'API_PURCHASE',
            'sessionId' => $uuid,
            'serviceParams' => [
                'merchantUid' => $this->config['merchant_id'],
                'apiUserId' => $this->config['user_id'],
                'apiKey' => $this->config['api_key'],
                'paymentMethod' => $payload['payment_method'] ?? 'MWALLET_ACCOUNT',
                'payerInfo' => [
                    'accountNo' => $phone,
                ],
                'transactionInfo' => [
                    'referenceId' => (string) ($payload['reference_id'] ?? $uuid),
                    'invoiceId' => (string) ($payload['invoice_id'] ?? $uuid),
                    'amount' => number_format((float) $payload['amount'], 2, '.', ''),
                    'currency' => $payload['currency'] ?? 'USD',
                    'description' => $payload['description'] ?? 'Payment',
                ],
            ],
        ]);


        if ($response->failed()) {
            throw new Exception("Waafi API request failed: " . $response->body());
        }

        $data = $response->json();

        if (($data['responseMsg'] ?? '') !== 'RCS_SUCCESS') {
            throw new Exception("Waafi Error: " . ($data['responseMsg'] ?? 'Unknown Error'));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function verify(string $transactionId): mixed
    {
        // Waafi usually uses checkStatus for verification
        return $this->checkStatus($transactionId);
    }

    /**
     * @inheritDoc
     */
    public function checkStatus(string $reference): mixed
    {
        $response = Http::post($this->config['base_url'], [
            'schemaVersion' => '1.0',
            'requestId' => uniqid(),
            'timestamp' => now()->timestamp,
            'channelName' => 'WEB',
            'serviceName' => 'API_CHECK_STATUS',
            'serviceParams' => [
                'merchantUid' => $this->config['merchant_id'],
                'apiUserId' => $this->config['user_id'],
                'apiKey' => $this->config['api_key'],
                'referenceId' => $reference,
            ],
        ]);

        return $response->json();
    }
}
