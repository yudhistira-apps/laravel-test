<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'published_year'
    ];

    protected $appends = ['avg_review', 'review_count', 'author_book_id'];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function getAvgReviewAttribute() {
        return BookReview::where('book_id', $this->id)->avg('review');
    }

    public function getReviewCountAttribute() {
        return BookReview::where('book_id', $this->id)->count();
    }

    public function getAuthorBookIdAttribute() {
        return Author::join('book_author', function ($query) {
                            $query->on('book_author.author_id', '=', 'authors.id')
                                    ->where('book_author.book_id', $this->id);
                        })
                        ->pluck('id')
                        ->first();
    }
}
