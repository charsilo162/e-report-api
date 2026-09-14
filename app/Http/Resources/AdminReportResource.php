<?php

//app/Http/Resources/AdminReportResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminReportResource extends JsonResource
{
    public function toArray($request): array
    {
        return array_merge(
            (new ReportResource($this->resource))->toArray($request),
            [
                'reporter' => $this->is_anonymous ? null : [
                    'nickName' => $this->user?->nickname,
                    'email' => $this->user?->email,
                    'phone' => $this->user?->phone,
                    'walletId' => $this->user?->wallet_id,
                ],
            ]
        );
    }
}