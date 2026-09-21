<?php

namespace App\Services;

//app/Services/CategoryService.php
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService extends BaseCrudService
{
    protected string $modelClass = Category::class;

    public function create(array $data): Category
    {
        $data['slug'] = $this->uniqueSlug($data['label']);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('categories', 'public');
        }

        return parent::create($data);
    }

    public function update(Model $model, array $data): Category
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $this->deleteStoredImage($model->image);
            $data['image'] = $data['image']->store('categories', 'public');
        } else {
            unset($data['image']); // no new file uploaded — keep the existing one
        }

        return parent::update($model, $data);
    }

    public function delete(Model $model): void
    {
        $this->deleteStoredImage($model->image);
        $model->delete();
    }

    protected function deleteStoredImage(?string $image): void
    {
        // Skip legacy seeded placeholder paths (e.g. "/assets/categories/hotel.jpg")
        // that were never actually stored on this disk.
        if ($image && ! str_starts_with($image, 'http') && ! str_starts_with($image, '/')) {
            Storage::disk('public')->delete($image);
        }
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