<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SafepayWebhookController extends Controller
{
    public function handle(Request $request, SubscriptionService $service): JsonResponse
    {
        $signature = $request->header('X-SFPY-SIGNATURE') ?? '';
        $payload = $request->all();

        if (empty($signature)) {
            Log::warning('Safepay webhook received without X-SFPY-SIGNATURE header');

            return response()->json(['error' => 'Missing signature header'], 400);
        }

        $result = $service->handleWebhookPayload($payload, $signature);

        if ($result['status'] === 'error') {
            Log::warning('Safepay webhook rejected: '.($result['message'] ?? 'Unknown error'));

            return response()->json(['error' => $result['message']], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Webhook processed successfully',
        ]);
    }
}
