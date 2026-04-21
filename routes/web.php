<?php

use Illuminate\Support\Facades\Route;
use Gadhyare\HornPay\Http\Controllers\WebhookController;

Route::prefix('horn-pay')->group(function () {
    Route::post('webhook/waafi', [WebhookController::class, 'handleWaafi'])->name('hornpay.webhook.waafi');
});
