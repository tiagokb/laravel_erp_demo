<?php

namespace App\Http\Controllers;

use App\Events\WebhookReceivedEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $status = $request->input('status');

        if ($id == null || $status == null) return response()->json('BAD REQUEST', 400);

        WebhookReceivedEvent::dispatch($id, $status);

        return response()->json('OK', 200);
    }
}
