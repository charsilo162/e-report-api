<?php

namespace App\Http\Requests;

//app/Http/Requests/UpdateReportStatusRequest.php
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReportStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                'Submitted', 'Under Review', 'Approved', 'In Progress', 'Resolved', 'Rejected',
            ])],
        ];
    }
}