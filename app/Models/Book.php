<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'anoPublicacao',
        'valor'
    ];

    public function authors()
    {
        return $this->hasMany(BookAuthors::class);
    }

    public function subjects()
    {
        return $this->hasMany(BookSubjects::class);
    }
}
