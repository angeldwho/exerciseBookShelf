<?php

namespace App\Interfaces\IRepositories;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

interface BookRepositoryInterface extends RepositoryInterface
{
    public function create(StoreBookRequest $storeBookRequest);
    public function update($bookId, UpdateBookRequest $updateBookRequest);
    public function getBooksToRead();
}
