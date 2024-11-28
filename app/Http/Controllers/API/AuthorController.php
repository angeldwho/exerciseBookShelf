<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Interfaces\IRepositories\AuthorRepositoryInterface;

class AuthorController extends Controller
{
    protected $authorRepositoryInterface;
    public function __construct(AuthorRepositoryInterface $authorRepositoryInterface)
    {
        $this->authorRepositoryInterface = $authorRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->authorRepositoryInterface->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $storeAuthorRequest)
    {
        return $this->authorRepositoryInterface->create($storeAuthorRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show($authorId)
    {
       return $this->authorRepositoryInterface->getById($authorId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($authorId, UpdateAuthorRequest $updateAuthorRequest)
    {
        return $this->authorRepositoryInterface->update($authorId,$updateAuthorRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($authorId)
    {
        return $this->authorRepositoryInterface->delete($authorId);
    }
}
