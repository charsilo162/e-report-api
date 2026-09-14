<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}