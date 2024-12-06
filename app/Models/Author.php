<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName','lastName','birthday'
    ];
    public function books() : BelongsToMany
    {
        return $this->belongsToMany(Book::class,'books_authors','author_id','book_id')
        ->as('books_authors')
        ->withTimestamps();
    }
}
