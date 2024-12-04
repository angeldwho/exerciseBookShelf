<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\IRepositories\BookRepositoryInterface;

class BookController extends Controller
{
    protected $bookRepositoryInterface;
    public function __construct(BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->bookRepositoryInterface = $bookRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->bookRepositoryInterface->getAll();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $storeBookRequest)
    {
        return $this->bookRepositoryInterface->create($storeBookRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show($bookId)
    {
        return $this->bookRepositoryInterface->getById($bookId);
    }

    public function getBooksToRead(){
        return $this->bookRepositoryInterface->getBooksToRead();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($bookId, UpdateBookRequest $updateBookRequest)
    {
        return $this->bookRepositoryInterface->update($bookId,$updateBookRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bookId)
    {
        return $this->bookRepositoryInterface->delete($bookId);
    }
}
