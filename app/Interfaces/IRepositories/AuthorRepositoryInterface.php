<?php

namespace App\Interfaces\IRepositories;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;

interface AuthorRepositoryInterface extends RepositoryInterface
{
    public function create(StoreAuthorRequest $storeAuthorRequest);
    public function update($authorId, UpdateAuthorRequest $updateAuthorRequest);
}
