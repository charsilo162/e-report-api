<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseStudyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
            'image' => ['required', 'string', 'max:2048'],
            'detail_title' => ['required', 'string', 'max:255'],
            'case_details' => ['required', 'string'],
            'evidence' => ['required', 'array', 'min:1'],
            'evidence.*.title' => ['required', 'string', 'max:255'],
            'evidence.*.description' => ['required', 'string'],
            'monetary_amount' => ['required', 'string'],
            'outcome' => ['required', 'string'],
            'stats' => ['required', 'array'],
            'stats.amountRecovered' => ['required', 'string'],
            'stats.reportDate' => ['required', 'string'],
            'stats.resolutionDate' => ['required', 'string'],
            'stats.legalFrameworkUsed' => ['required', 'string'],
        ];
    }
}