<?php

namespace App;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    protected $guarded = [];

    public function genres(){
        return $this->belongsToMany('App\Genre', 'genre_movies',
            'movie_id', 'genre_id');
     }

     public function subtitles(){
         return $this->belongsToMany('App\Subtitle');
     }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
//        return Carbon::parse($date)->format('d-M-Y H:i:s');
    }

    //   // this is a recommended way to declare event handlers
//     public static function boot() {
//         parent::boot();
//         self::deleting(function($movies) { // before delete() method call this
//             $movies->genres()->each(function($genres) {
//                 $genres->delete(); // <-- direct deletion
//             });
//             // do the rest of the cleanup...
//         });
//     }
}
