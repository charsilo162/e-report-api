<?php

namespace App\Http\Resources;
//app/Http/Resources/CategoryResource.php

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'label' => $this->label,
            'image' => $this->resolveImageUrl($this->image),
        ];
    }

       protected function resolveImageUrl(?string $image): ?string
{
    if (! $image) {
        return null;
    }

    if (str_starts_with($image, 'http')) {
        return $image;
    }

    // Clean up leading slashes or 'storage/' prefixes to prevent duplication
    $cleanPath = ltrim($image, '/');
    if (str_starts_with($cleanPath, 'storage/')) {
        $cleanPath = substr($cleanPath, 8);
    }

    // asset() automatically prepends your APP_URL domain name
    return asset('storage/' . $cleanPath);
}
}