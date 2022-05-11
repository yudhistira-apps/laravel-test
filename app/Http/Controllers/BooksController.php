<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // @TODO implement
        $book = Book::with(
            [
                'authors' => function ($queryAuthor) {
                    $queryAuthor->select('id', 'name', 'surname');
                }
            ],
            [
                'reviews' => function ($query) { 
                    $query->select('avg', 'count'); 
                }
            ]
        );

        // if ($request->title) {
        //     $book->orderBy('title', $request->title);
        // }
        // if ($request->avg_review) {
        //     $book->orderBy(DB::raw('(SELECT AVG(review) AS avg FROM book_reviews where book_id = books.id)'), $request->avg_review);
        // }
        // if ($request->published_year) {
        //     $book->orderBy('published_year', $request->published_year);
        // }

        // $where = array();

        if ($request->title) {
            return BookResource::collection($book->paginate());
        }
        if ($request->authors) {
            return BookResource::collection($book->paginate());
        }
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = new Book();
        $book->create($request->all());

        return new BookResource($book);
    }
}
