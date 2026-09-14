<?php

namespace App\Services;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class FaqService extends BaseCrudService
{
    protected string $modelClass = Faq::class;

    public function all(): Collection
    {
        return Faq::orderBy('order')->get();
    }
}