<?php

namespace App\Repositories;

use Throwable;
use App\Models\Category;
use App\Utils\ApiCustomResponse;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Interfaces\IRepositories\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function create(StoreCategoryRequest $storeCategoryRequest)
    {
        try {
            $validatedData = $storeCategoryRequest->validated();
            $category = Category::create($validatedData);
            return ApiCustomResponse::sendResponse(($category), 'Category created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    public function update($categoryId, UpdateCategoryRequest $updateCategoryRequest)
    {
        try {
            $validatedData = $updateCategoryRequest->validated();
            $categoryFound = Category::find($categoryId);
            if (is_null($categoryFound)) {
                return ApiCustomResponse::sendError('Category not found.');
            }
            $categoryFound->name = $validatedData['name'];
            $categoryFound->save();

            return ApiCustomResponse::sendResponse($categoryFound, 'Category updated successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
}
