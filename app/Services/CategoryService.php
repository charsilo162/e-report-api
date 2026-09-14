<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService extends BaseCrudService
{
    protected string $modelClass = Category::class;

    public function create(array $data): Category
    {
        $data['slug'] = $this->uniqueSlug($data['label']);

        return parent::create($data);
    }

    protected function uniqueSlug(string $label, ?int $ignoreId = null): string
    {
        $base = Str::slug($label);
        $slug = $base;
        $i = 2;

        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}