<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gated by the 'admin' route middleware, not per-field auth
    }

    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:2048'],
        ];
    }
}