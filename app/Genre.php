<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];

    public function movies(){
        return $this->belongsToMany('\App\Movies', 'genre_movies',
            'genre_id', 'movie_id');
     }

}
