# Horn Pay

A powerful Laravel package for integrating mobile money payments in the Horn of Africa. This package provides a unified API to interact with various payment gateways like **Waafi (Waafipay)** and **eDahab**.

## Features

- Unified interface for multiple payment gateways.
- Support for **Waafi (Somalia/Djibouti)**.
- Support for **eDahab (Somaliland/Somalia)**.
- Easy configuration via environment variables.
- Built-in facades and service providers for Laravel.

## Installation

Since this package is hosted on GitHub, you can install it by adding the repository to your `composer.json` file:

### 1. Add Repository to `composer.json`

Add the following to your project's `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/gadhyare/horn-pay"
    }
],
```

### 2. Install via Composer

Run the following command in your terminal:

```bash
composer require gadhyare/horn-pay
```

### 3. Publish Configuration

Publish the package configuration file to your project:

```bash
php artisan vendor:publish --provider="Gadhyare\HornPay\HornPayServiceProvider"
```

This will create a `config/horn-pay.php` file where you can manage your settings.

## Configuration

Add the following keys to your `.env` file:

### General Settings
```env
HORN_PAY_DRIVER=waafi # Options: waafi, edahab
```

### Waafi (Waafipay) Settings
```env
WaafiApiKeyApiKey=your_api_key
MerchantUid=your_merchant_id
ApiUserId=your_api_user_id
WAAFI_PASSWORD=your_password
WAAFI_BASE_URL=https://api.waafipay.com/asm
WAAFI_REDIRECT_URL=https://your-site.com/payment/callback
WAAFI_PAYMENT_METHOD=MWALLET_ACCOUNT # e.g., ZAAD, SAHAL
```

### eDahab Settings
```env
EDAHAB_API_KEY=your_api_key
EDAHAB_AGENT_CODE=your_agent_code
EDAHAB_SECRET_KEY=your_secret_key
EDAHAB_BASE_URL=https://edahab.net/api/api/IssueInvoice
EDAHAB_RETURN_URL=https://your-site.com/payment/callback
```

## Usage

The package provides a `HornPay` facade for easy interaction.

### 1. Initiate a Purchase (Waafi Example)

```php
use Gadhyare\HornPay\Facades\HornPay;

$response = HornPay::driver('waafi')->purchase([
    'account_no' => '6xXXXXXXX', // Phone number
    'amount' => 10.00,
    'currency' => 'USD', // Optional, default is USD
    'description' => 'Payment for Order #123', // Optional
]);

// Waafi returns an array with the API response
if ($response['responseMsg'] === 'RCS_SUCCESS') {
    // Payment successful
}
```

### 2. Initiate a Purchase (eDahab Example)

```php
use Gadhyare\HornPay\Facades\HornPay;

$response = HornPay::driver('edahab')->purchase([
    'phone' => '65XXXXXXX',
    'amount' => 10.00,
]);

if ($response['InvoiceStatus'] === 'Paid') {
    // Payment successful
}
```

### 3. Check Transaction Status (Waafi)

```php
$status = HornPay::driver('waafi')->checkStatus($referenceId);
```

---

## Driver Payload Requirements

### Waafi
| Key | Required | Description |
|-----|----------|-------------|
| `account_no` | Yes | The customer's mobile number. |
| `amount` | Yes | The amount to charge. |
| `currency` | No | Currency code (default: `USD`). |
| `description`| No | Payment description. |

### eDahab
| Key | Required | Description |
|-----|----------|-------------|
| `phone` | Yes | The customer's mobile number. |
| `amount` | Yes | The amount to charge. |
| `return_url`| No | Custom return URL. |

## Supported Drivers

| Driver | Provider | Region |
|--------|----------|--------|
| `waafi` | Waafipay | Somalia, Djibouti |
| `edahab` | eDahab | Somaliland, Somalia |

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
