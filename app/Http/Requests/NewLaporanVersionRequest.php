<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewLaporanVersionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
        ];
    }
}
