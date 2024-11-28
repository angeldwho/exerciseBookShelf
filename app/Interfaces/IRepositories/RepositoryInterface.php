<?php

namespace App\Interfaces\IRepositories;

use Illuminate\Foundation\Http\FormRequest;

interface RepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    //public function create(FormRequest $formRequest);
    //public function update($id, $newDetails);
}
