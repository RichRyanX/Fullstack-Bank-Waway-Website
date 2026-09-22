<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplianceReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $status = $this->input('status', 'DRAFT');
        $fileRule = $status === 'PUBLISHED' ? 'required' : 'nullable';

        return [
            'file' => $fileRule . '|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
        ];
    }
}
