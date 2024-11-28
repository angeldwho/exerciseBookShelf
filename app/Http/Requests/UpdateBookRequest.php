<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes','string','max:200'],
            'summary' => ['string','max:500'],
            'isbn' => ['sometimes','unique:books','string','size:17'],
            'toRead' => ['sometimes','boolean'],
            'authors' => 'sometimes|array', // Array di ID degli autori
            'authors.*' => 'exists:authors,id', // Ogni elemento deve esistere nella tabella authors
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id'
        ];
    }
}
