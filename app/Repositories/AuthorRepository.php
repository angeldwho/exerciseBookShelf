<?php

namespace App\Repositories;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Throwable;
use App\Models\Author;
use App\Utils\ApiCustomResponse;
use App\Interfaces\IRepositories\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    public function __construct(Author $author)
    {
        parent::__construct($author);
    }


    public function create(StoreAuthorRequest $storeAuthorRequest)
    {
        try {
            $validatedData = $storeAuthorRequest->validated();
            $author = Author::create($validatedData);
            return ApiCustomResponse::sendResponse($author, 'Author created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }



    public function update($authorId, UpdateAuthorRequest $updateAuthorRequest)
    {
        try {
            $validatedData = $updateAuthorRequest->validated();
            $authorFound = Author::find($authorId);
            if (is_null($authorFound)) {
                return ApiCustomResponse::sendError('Author not found.');
            }
            $authorFound->update($validatedData);

            return ApiCustomResponse::sendResponse($authorFound, 'Author updated successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }

    }
}

