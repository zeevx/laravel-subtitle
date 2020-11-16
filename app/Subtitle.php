<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    protected $guarded = [];

    public function movie(){
        return $this->belongsTo(\App\Movies::class);
     }
}
