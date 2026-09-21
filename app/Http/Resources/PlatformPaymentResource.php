<?php

//app/Http/Resources/PlatformPaymentResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformPaymentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'id' => '#REPT'.str_pad($this->report_id, 3, '0', STR_PAD_LEFT),
            'amount' => '₦'.number_format($this->amount, 2),
            'date' => $this->created_at->format('M d, Y - h:i A'),
            'walletId' => $this->user->wallet_id,
            'userType' => $this->report->is_anonymous ? 'Anonymous' : ($this->user->nickname ?? 'Unknown'),
            'status' => $this->report->status,
        ];
    }
}