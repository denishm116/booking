<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rservice extends Model
{
    public $timestamps = false; /* Lecture 50 */
    public $guarded = [];

    public function rooms()
    {
        return $this->morphToMany('App\Room', 'rsortable');
    }


    public function objects()
    {
        return $this->morphToMany('App\TouristObject', 'osortable');
    }



}
