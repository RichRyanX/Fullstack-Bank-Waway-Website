<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'modul' => 'required|string|max:100',
            'pesan' => 'required|string|max:5000',
        ];
    }
}
