<?php

namespace App\Http\Resources;
//app/Http/Resources/AdminReportListResource.php

use Illuminate\Http\Resources\Json\JsonResource;

class AdminReportListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'id' => '#REPT'.str_pad($this->id, 3, '0', STR_PAD_LEFT),
            'category' => $this->categories->pluck('label')->join(', '),
            'date' => $this->created_at->format('M d, Y - h:i A'),
            'status' => $this->status,
            'submittedBy' => $this->is_anonymous
                ? 'Anonymous'
                : ($this->user->nickname ?? $this->user->name ?? 'Unknown'),
        ];
    }
}