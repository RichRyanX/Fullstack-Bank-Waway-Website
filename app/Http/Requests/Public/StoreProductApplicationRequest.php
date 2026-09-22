<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_type' => 'required|string|in:kredit,deposito,tabungan',
            'product_id' => 'nullable|integer',
            'product_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:100000',
            'tenure' => 'required|integer|min:1|max:360',
            'applicant_name' => 'required|string|max:150',
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/',
            'phone' => 'required|string|max:30|regex:/^[0-9\+\-\(\)\s]+$/',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:2000',
        ];
    }
}
