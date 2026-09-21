<?php

namespace App\Http\Resources;
//app/Http/Resources/PlatformTopupResource.php

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformTopupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'label' => 'Wallet top-up via '.$this->method,
            'date' => $this->created_at->format('Y-m-d'),
            'amount' => '+₦'.number_format($this->amount, 2),
        ];
    }
}