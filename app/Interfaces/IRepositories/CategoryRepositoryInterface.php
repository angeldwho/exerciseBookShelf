<?php

namespace App\Interfaces\IRepositories;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function create(StoreCategoryRequest $storeCategoryRequest);
    public function update($categoryId, UpdateCategoryRequest $updateCategoryRequest);
}
