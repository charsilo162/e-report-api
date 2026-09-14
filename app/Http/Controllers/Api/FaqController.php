<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use App\Services\FaqService;

class FaqController extends Controller
{
    public function __construct(protected FaqService $faqs)
    {
    }

    public function index()
    {
        return FaqResource::collection($this->faqs->all());
    }

    public function store(FaqRequest $request)
    {
        return new FaqResource($this->faqs->create($request->validated()));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        return new FaqResource($this->faqs->update($faq, $request->validated()));
    }

    public function destroy(Faq $faq)
    {
        $this->faqs->delete($faq);

        return response()->json(['message' => 'FAQ deleted.']);
    }
}