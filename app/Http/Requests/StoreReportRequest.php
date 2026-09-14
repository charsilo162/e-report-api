<?php
namespace App\Http\Requests;

//app/Http/Requests/StoreReportRequest.php
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public endpoint — anonymous reporting is a core feature, not gated by auth
    }

    public function rules(): array
    {
        return [
            'org_name' => ['required', 'string', 'max:255'],
            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
            'wrongdoing' => ['required', 'array', 'min:1'],
            'wrongdoing.*' => ['string', 'max:255'],
            'incident_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'report_to' => ['nullable', 'string', 'max:255'],
            'is_anonymous' => ['required', 'boolean'],
            'description' => ['required', 'string', 'max:500'],

            'suspects' => ['required', 'array', 'min:1', 'max:5'],
            'suspects.*.full_name' => ['required', 'string', 'max:255'],
            'suspects.*.position' => ['nullable', 'string', 'max:255'],
            'suspects.*.phone' => ['nullable', 'string', 'max:50'],
            'suspects.*.email' => ['nullable', 'email', 'max:255'],

            'files' => ['nullable', 'array'],
            'files.*' => [
                'file',
                'max:204800', // 200MB — Laravel's file `max` rule is interpreted in kilobytes
                'mimes:pdf,doc,docx,mp4,mp3,jpg,jpeg,png,gif,mkv,wav,avi,webp,zip,rar',
            ],
        ];
    }
}