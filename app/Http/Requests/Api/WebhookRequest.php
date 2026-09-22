<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class WebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        $signature = $this->header('X-Signature');
        $timestamp = $this->header('X-Timestamp');

        if (!$signature || !$timestamp) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $timestamp . '.' . $this->getContent(), config('services.webhook.secret', 'secret'));

        return hash_equals($expectedSignature, $signature);
    }

    public function rules(): array
    {
        return [];
    }

    protected function failedAuthorization()
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED)
        );
    }
}
