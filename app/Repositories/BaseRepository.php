<?php

namespace App\Repositories;

use Throwable;
use ReflectionClass;
use App\Utils\ApiCustomResponse;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\IRepositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $modelName;

    public function __construct(Model $model){
        $this->model= $model;

        $reflection = new ReflectionClass($this->model);
        $this->modelName = $reflection->getShortName();
    }

    public function getAll(){
        try {
            $elementsRetrieve =  $this->model::all();
            if (is_null($elementsRetrieve)) {
                return ApiCustomResponse::sendResponse("There\'s no $this->modelName , sorry", 202);
            }
            return ApiCustomResponse::sendResponse(($elementsRetrieve), "$this->modelName retrieved successfully");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }

    /*public function create(FormRequest $storeRequest)
    {
        try {
            $validatedData = $storeRequest->validated();
            $objectCreating = $this->model::create($validatedData);
            return ApiCustomResponse::sendResponse(new $this->resource($objectCreating), '{$this->modelName} created successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }*/
    public function getById($id)
    {
        try {
            $element = $this->model::find($id);
            if (is_null($element)) {
                return ApiCustomResponse::sendError("$this->modelName not found.");
            } else
                return ApiCustomResponse::sendResponse(($element), "$this->modelName found.");
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
    /*public function update($id, $updateRequest)
    {
        try {
            $validatedData = $updateRequest->validated();
            $elementToFind = $this->model::find($id);
            if (is_null($elementToFind)) {
                return ApiCustomResponse::sendError('{$this->modelName} not found.');
            }
            $elementToFind->update($validatedData);

            return ApiCustomResponse::sendResponse(new $this->resource($elementToFind), '{$this->modelName} updated successfully.');
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }*/

    public function delete($id)
    {
        try {
            if ($this->model::where('id', $id)->exists()) {
                $elementToDelete = $this->model::where('id',$id)
                        ->delete();
                return ApiCustomResponse::sendResponse("$this->modelName deleted",202);
            } else {
                return ApiCustomResponse::sendError("$this->modelName not found", '', 404);
            }
        } catch (Throwable $e) {
            return ApiCustomResponse::sendError('An unexcepted error occured', $e->getMessage(), 500);
        }
    }
}
