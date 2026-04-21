<?php

namespace Gadhyare\HornPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed purchase(array $payload)
 * @method static mixed verify(string $transactionId)
 * @method static mixed checkStatus(string $reference)
 * @method static \Gadhyare\HornPay\Contracts\PaymentGatewayInterface driver(string|null $driver = null)
 * 
 * @see \Gadhyare\HornPay\HornPayManager
 */
class HornPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'horn-pay';
    }
}
