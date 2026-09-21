<?php

namespace App\Http\Resources;
//app/Http/Resources/AdminUserListResource.php

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'id' => '#USR'.str_pad($this->id, 3, '0', STR_PAD_LEFT),
            'nickName' => $this->nickname,
            'role' => ucfirst($this->role),
            'reportsCount' => $this->reports_count,
            'status' => $this->suspended_at ? 'Suspended' : 'Active',
            'lastLogin' => $this->last_login_at?->format('M d - h:ia') ?? 'Never',
        ];
    }
}