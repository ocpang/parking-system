<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'title', 'author', 'genre', 'vote_count'];

}
