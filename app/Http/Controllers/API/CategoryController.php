<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Interfaces\IRepositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepositoryInterface;
    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->categoryRepositoryInterface->getAll();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        $this->categoryRepositoryInterface->create($storeCategoryRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {
        $this->categoryRepositoryInterface->getById($categoryId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($categoryId, UpdateCategoryRequest $updateCategoryRequest)
    {
        $this->categoryRepositoryInterface->update($categoryId,$updateCategoryRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId)
    {
        $this->categoryRepositoryInterface->delete($categoryId);
    }
}
