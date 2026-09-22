<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBantuanTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subjek' => 'required|string|max:255',
            'modul' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:5000',
        ];
    }
}
