<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthors extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'author_id',
    ];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
