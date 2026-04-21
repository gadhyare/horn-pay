<?php

namespace Gadhyare\HornPay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle WAAFI Webhook/Callback.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleWaafi(Request $request)
    {
        $payload = $request->all();

        Log::info('HornPay Webhook Received:', $payload);

        // Logic to update transaction status based on payload
        // Example: $transaction = Transaction::where('reference', $payload['referenceId'])->first();
        // $transaction->update(['status' => $payload['state']]);

        return response()->json(['status' => 'success']);
    }
}
