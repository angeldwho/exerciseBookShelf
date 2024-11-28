<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;
    //tutti i modelli dovrebbero avere l'attributo fillable
    //per prevenire il Mass Assignment non autorizzato
    protected $fillable = [
        'title','summary','isbn','toRead'
    ];
    public function authors() : BelongsToMany
    {
        return $this->belongsToMany(Author::class,'books_authors','book_id','author_id')->withTimestamps();
    }
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class,'books_categories','book_id','category_id')->withTimestamps();
    }
}
