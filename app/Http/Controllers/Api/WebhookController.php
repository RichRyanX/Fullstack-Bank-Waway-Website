<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WebhookRequest;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function handle(WebhookRequest $request)
    {
        return response()->json(['status' => 'success']);
    }
}
