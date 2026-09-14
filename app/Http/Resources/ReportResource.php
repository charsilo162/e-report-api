<?php

namespace App\Http\Resources;
//app/Http/Resources/ReportResource.php

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'passcode' => $this->passcode,
            'orgName' => $this->org_name,
            'location' => $this->location,
            'incidentDate' => $this->incident_date->format('Y-m-d'),
            'wrongdoing' => $this->wrongdoing,
            'description' => $this->description,
            'reportTo' => $this->report_to,
            'isAnonymous' => $this->is_anonymous,
            'status' => $this->status,
            'categories' => $this->whenLoaded('categories', fn () => $this->categories->pluck('label')),
            'suspects' => $this->whenLoaded('suspects', fn () => $this->suspects->map(fn ($s) => [
                'fullName' => $s->full_name,
                'position' => $s->position,
                'phone' => $s->phone,
                'email' => $s->email,
            ])),
            'evidence' => $this->whenLoaded('evidenceFiles', fn () => $this->evidenceFiles->map(fn ($f) => [
                'name' => $f->original_name,
                'size' => $this->formatBytes($f->size),
            ])),
            'createdAt' => $this->created_at,
        ];
    }

    protected function formatBytes(int $bytes): string
    {
        return $bytes >= 1048576
            ? round($bytes / 1048576).'MB'
            : round($bytes / 1024).'KB';
    }
}