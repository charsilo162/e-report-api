<?php

namespace App\Http\Resources;
//app/Http/Resources/AdminUserDetailResource.php

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'id' => '#USR'.str_pad($this->id, 3, '0', STR_PAD_LEFT),
            'nickName' => $this->nickname,
            'email' => $this->email,
            'phone' => $this->phone,
            'joinedDate' => $this->created_at->format('d M Y'),
            'status' => $this->suspended_at ? 'Suspended' : 'Active',
            'companyName' => $this->company_name,
            'reportHistory' => $this->reports->map(fn ($r) => [
                'key' => $r->id,
                'id' => '#REPT'.str_pad($r->id, 3, '0', STR_PAD_LEFT),
                'category' => $r->categories->pluck('label')->join(', '),
                'date' => $r->created_at->format('M d, Y - h:i A'),
                'status' => $r->status,
            ]),
        ];
    }
}