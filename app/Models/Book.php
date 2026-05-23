<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable =[
        'title',
        'author',
        'year',
        'publisher',
        'city',
        'cover',
        'bookshelf_id',
    ];

    public static function getDataBooks(){
        $books = Book::all();
        $books_filter = [];
        $no = 1;
        for($i=0; $i<$books->count(); $i++){
            $books_filter[$i]['no']  = $no++;
            $books_filter[$i]['title'] = $books[$i]->title;
            $books_filter[$i]['author'] = $books[$i]->author;
            $books_filter[$i]['year'] = $books[$i]->year;
            $books_filter[$i]['publisher'] = $books[$i]->publisher;
            $books_filter[$i]['city'] = $books[$i]->city;
        }
        return $books_filter;
    }

    public function bookshelf()
    {
        return $this->belongsTo(Bookshelf::class, 'bookshelf_id', 'id');
    }


}
