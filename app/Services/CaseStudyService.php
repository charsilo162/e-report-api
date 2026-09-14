<?php

namespace App\Services;

use App\Models\CaseStudy;
use Illuminate\Support\Str;

class CaseStudyService extends BaseCrudService
{
    protected string $modelClass = CaseStudy::class;

    public function create(array $data): CaseStudy
    {
        $data['slug'] = $this->uniqueSlug($data['title']);

        return parent::create($data);
    }

    public function findBySlug(string $slug): CaseStudy
    {
        return CaseStudy::where('slug', $slug)->firstOrFail();
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 2;

        while (
            CaseStudy::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}