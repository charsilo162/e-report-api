<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseCrudService
{
    protected string $modelClass;

    public function all(): Collection
    {
        return $this->modelClass::all();
    }

    public function find(int|string $id): Model
    {
        return $this->modelClass::findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->modelClass::create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model->fresh();
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}