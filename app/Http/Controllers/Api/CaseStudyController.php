<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStudyRequest;
use App\Http\Resources\CaseStudyResource;
use App\Models\CaseStudy;
use App\Services\CaseStudyService;

class CaseStudyController extends Controller
{
    public function __construct(protected CaseStudyService $caseStudies)
    {
    }

    public function index()
    {
        return CaseStudyResource::collection($this->caseStudies->all());
    }

    public function show(string $slug)
    {
        return new CaseStudyResource($this->caseStudies->findBySlug($slug));
    }

    public function store(CaseStudyRequest $request)
    {
        return new CaseStudyResource($this->caseStudies->create($request->validated()));
    }

    public function update(CaseStudyRequest $request, CaseStudy $caseStudy)
    {
        return new CaseStudyResource($this->caseStudies->update($caseStudy, $request->validated()));
    }

    public function destroy(CaseStudy $caseStudy)
    {
        $this->caseStudies->delete($caseStudy);

        return response()->json(['message' => 'Case study deleted.']);
    }
}