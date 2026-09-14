<?php

namespace App\Http\Requests;
//app/Http/Requests/CreditWalletRequest.php

use Illuminate\Foundation\Http\FormRequest;

class CreditWalletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wallet_id' => ['required', 'string', 'exists:users,wallet_id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}