<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categories)
    {
    }

    public function index()
    {
        return CategoryResource::collection($this->categories->all());
    }



    public function store(CategoryRequest $request)
    {
        return new CategoryResource($this->categories->create($request->validated()));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        return new CategoryResource($this->categories->update($category, $request->validated()));
    }
 
    public function destroy(Category $category)
    {
        $this->categories->delete($category);

        return response()->json(['message' => 'Category deleted.']);
    }
}