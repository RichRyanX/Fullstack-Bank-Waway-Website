<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => 'required|string',
            'tahun_buku' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
        ];
    }
}
