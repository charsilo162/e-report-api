<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseStudyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'slug' => $this->slug,
            'tag' => $this->tag,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'image' => $this->image,
            'detailTitle' => $this->detail_title,
            'caseDetails' => $this->case_details,
            'evidence' => $this->evidence,
            'monetaryAmount' => $this->monetary_amount,
            'outcome' => $this->outcome,
            'stats' => $this->stats,
        ];
    }
}