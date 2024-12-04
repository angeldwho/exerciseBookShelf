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

    public function getAll(){
        try {
            $elementsRetrieve =  $this->model::with(['books_authors','books_categories'])->get();
            if (is_null($elementsRetrieve)) {
                return ApiCustomResponse::sendResponse("There\'s no $this->modelName , sorry", 202);
            }
            return ApiCustomResponse::sendResponse(($elementsRetrieve), "$this->modelName retrieved successfully");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
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

    public function getById($id)
    {
        try {
            $book = $this->model::find($id)::with(['categories','authors'])->get();
            if (is_null($book)) {
                return ApiCustomResponse::sendError("$this->modelName not found.");
            } else
                return ApiCustomResponse::sendResponse(($book), "$this->modelName found.");
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

