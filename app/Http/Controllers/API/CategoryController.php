<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\Category;
use App\Utils\ApiCustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $elementsRetrieve =  Category::all();
            if (is_null($elementsRetrieve)) {
                return ApiCustomResponse::sendResponse("There\'s no category , sorry", 202);
            }
            return ApiCustomResponse::sendResponse(($elementsRetrieve), "Category retrieved successfully");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        try {
            $validatedData = $storeCategoryRequest->validated();
            $category = Category::create($validatedData);
            return ApiCustomResponse::sendResponse(($category), 'Category created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {
        try {
            $element = Category::find($categoryId);
            if (is_null($element)) {
                return ApiCustomResponse::sendError("Category not found.");
            } else
                return ApiCustomResponse::sendResponse(($element), "Category found.");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId)
    {
        try {
            if (Category::where('id', $categoryId)->exists()) {
                $elementToDelete = Category::where('id',$categoryId)
                        ->delete();
                return ApiCustomResponse::sendResponse("Category deleted",202);
            } else {
                return ApiCustomResponse::sendError("Category not found", '', 404);
            }
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
}
