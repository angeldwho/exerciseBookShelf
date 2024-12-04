<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\Author;
use App\Utils\ApiCustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $elementsRetrieve =  Author::all();
            if (is_null($elementsRetrieve)) {
                return ApiCustomResponse::sendResponse("There\'s no author , sorry", 202);
            }
            return ApiCustomResponse::sendResponse(($elementsRetrieve), "Authors retrieved successfully");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $storeAuthorRequest)
    {
        try {
            $validatedData = $storeAuthorRequest->validated();
            $author = Author::create($validatedData);
            return ApiCustomResponse::sendResponse($author, 'Author created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($authorId)
    {
        try {
            $element = Author::find($authorId);
            if (is_null($element)) {
                return ApiCustomResponse::sendError("Author not found.");
            } else
                return ApiCustomResponse::sendResponse(($element), "Author found.");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($authorId)
    {
        try {
            if (Author::where('id', $authorId)->exists()) {
                $elementToDelete = Author::where('id',$authorId)
                        ->delete();
                return ApiCustomResponse::sendResponse("Author deleted",202);
            } else {
                return ApiCustomResponse::sendError("Author not found", '', 404);
            }
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
}
