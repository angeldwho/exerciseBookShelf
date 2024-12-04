<?php

namespace App\Http\Controllers\API;


use Exception;
use Throwable;
use App\Models\Book;
use App\Utils\ApiCustomResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    private AuthorController $authorController;
    private CategoryController $categoryController;
    public function __construct( AuthorController $authorController,  CategoryController $categoryController)
    {
        $this->authorController = $authorController;
        $this->categoryController = $categoryController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books =  Book::all();
            $books->load('authors');
            $books->load('categories');

            if (is_null($books)) {
                return ApiCustomResponse::sendResponse("There\'s no book , sorry", 202);
            }
            return ApiCustomResponse::sendResponse(($books), "Books retrieved successfully");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $storeBookRequest)
    {
        try {

            $selectedAuthorsId = $storeBookRequest->input('authors');
            $selectedCategoriesId = $storeBookRequest->input('categories');
            foreach ($selectedAuthorsId as $authorId) {
                $this->authorController->show($authorId);
            }
            foreach ($selectedCategoriesId as $categoryId) {
                $this->categoryController->show($categoryId);
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
            }catch(Exception $ex){
                return DB::rollback($ex);
            }

            return ApiCustomResponse::sendResponse($book, 'Book created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($bookId)
    {
        try {
            $book = Book::find($bookId);
            $book->load('authors');
            $book->load('categories');
            if (is_null($book)) {
                return ApiCustomResponse::sendError("Book not found.");
            } else
                return ApiCustomResponse::sendResponse(($book), "Book found.");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    public function getBooksToRead(){
        try {
            $books = DB::table('books')->where('toRead',0)->get();
            $books->load('authors');
            $books->load('categories');
            if (is_null($books)) {
                return ApiCustomResponse::sendError('Book not found');
            }
            return ApiCustomResponse::sendResponse($books,'ci dovrebbero essere libri.....');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bookId)
    {
        try {
            if (Book::where('id', $bookId)->exists()) {
                $elementToDelete = Book::where('id',$bookId)
                        ->delete();
                return ApiCustomResponse::sendResponse("Book deleted",202);
            } else {
                return ApiCustomResponse::sendError("Book not found", '', 404);
            }
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
}
