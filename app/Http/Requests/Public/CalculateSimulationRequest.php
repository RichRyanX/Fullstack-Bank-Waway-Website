<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class CalculateSimulationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_type' => 'required|string|in:kredit,deposito,tabungan',
            'amount' => 'required|numeric|min:100000',
            'tenure' => 'required|integer|min:1|max:360',
        ];
    }
}
