<?php

namespace App\Http\Requests;

//app/Http/Requests/TopUpRequest.php
use Illuminate\Foundation\Http\FormRequest;

class TopUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['nullable', 'string'],
        ];
    }
}