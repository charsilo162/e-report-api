<?php

namespace App\Http\Resources;

//app/Http/Resources/WalletTransactionResource.php
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'id' => 'TXN-'.str_pad($this->id, 5, '0', STR_PAD_LEFT),
            'type' => $this->type === 'Credit' && $this->report_id
                ? "Credit (Report #{$this->report_id} approved)"
                : $this->type,
            'date' => $this->created_at->format('M d, Y - h:i A'),
            'amount' => '₦'.number_format($this->amount, 2),
            'status' => $this->status,
        ];
    }
}