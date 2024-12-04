<?php

namespace App\Repositories;

use Throwable;
use App\Models\Book;
use App\Utils\ApiCustomResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\IRepositories\AuthorRepositoryInterface;
use App\Interfaces\IRepositories\BookRepositoryInterface;
use App\Interfaces\IRepositories\CategoryRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    protected $authorRepositoryInterface;
    protected $categoryRepositoryInterface;
    public function __construct(AuthorRepositoryInterface $authorRepositoryInterface,CategoryRepositoryInterface $categoryRepositoryInterface, Book $book)
    {
        $this->authorRepositoryInterface = $authorRepositoryInterface;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        parent::__construct($book);
    }

    public function create(StoreBookRequest $storeBookRequest)
    {
        try {

            $selectedAuthorsId = $storeBookRequest->input('authors');
            $selectedCategoriesId = $storeBookRequest->input('categories');
            foreach ($selectedAuthorsId as $authorId) {
                $this->authorRepositoryInterface->getById($authorId);
            }
            foreach ($selectedCategoriesId as $categoryId) {
                $this->categoryRepositoryInterface->getById($categoryId);
            }
            $validatedData = $storeBookRequest->validated();
            /*if($validatedData->fails()){
                return $this->sendError('Validation Error.', $validatedData->errors());
            }*/
            DB::beginTransaction();
            try{
                $book = Book::create($validatedData);
                $book->authors()->sync($selectedAuthorsId);
                $book->categories()->sync($selectedCategoriesId);
                DB::commit();
            }catch(\Exception $ex){
                return DB::rollback($ex);
            }

            return ApiCustomResponse::sendResponse($book, 'Book created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    public function getAll(){
        try {
            $books =  Book::all();
            $books->load('authors');
            $books->load('categories');

            if (is_null($books)) {
                return ApiCustomResponse::sendResponse("There\'s no $this->modelName , sorry", 202);
            }
            return ApiCustomResponse::sendResponse(($books), "$this->modelName retrieved successfully");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    public function update($bookId, UpdateBookRequest $updateBookRequest)
    {
        try {
            $validatedData = $updateBookRequest->validated();
            $bookFound = Book::findOrFail($bookId)
                        ->update($validatedData);

            return ApiCustomResponse::sendResponse($bookFound, 'Author updated successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    public function getBooksToRead()
    {
        try {
            $books = DB::table('books')->where('toRead',0)->get();
            if (is_null($books)) {
                return ApiCustomResponse::sendError('Book not found');
            }
            return ApiCustomResponse::sendResponse($books,'ci dovrebbero essere libri.....');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
}

