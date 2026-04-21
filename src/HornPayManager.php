<?php

namespace Gadhyare\HornPay;

use Gadhyare\HornPay\Drivers\WaafiDriver;
use Gadhyare\HornPay\Drivers\EdahabDriver;
use Illuminate\Support\Manager;
use InvalidArgumentException;

class HornPayManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('horn-pay.default');
    }

    /**
     * Create Waafi Driver.
     *
     * @return WaafiDriver
     */
    protected function createWaafiDriver()
    {
        $config = $this->config->get('horn-pay.drivers.waafi');

        if (is_null($config)) {
            throw new InvalidArgumentException("Waafi driver configuration not found.");
        }

        return new WaafiDriver($config);
    }

    /**
     * Create Edahab Driver.
     *
     * @return EdahabDriver
     */
    protected function createEdahabDriver()
    {
        $config = $this->config->get('horn-pay.drivers.edahab');

        if (is_null($config)) {
            throw new InvalidArgumentException("Edahab driver configuration not found.");
        }

        return new EdahabDriver($config);
    }
}
