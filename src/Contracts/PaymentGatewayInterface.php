<?php

namespace Gadhyare\HornPay\Contracts;

interface PaymentGatewayInterface
{
    /**
     * Initiate a purchase/payment request.
     *
     * @param array $payload
     * @return mixed
     */
    public function purchase(array $payload): mixed;

    /**
     * Verify a transaction via transaction ID.
     *
     * @param string $transactionId
     * @return mixed
     */
    public function verify(string $transactionId): mixed;

    /**
     * Check transaction status via reference.
     *
     * @param string $reference
     * @return mixed
     */
    public function checkStatus(string $reference): mixed;
}
