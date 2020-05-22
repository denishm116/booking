<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false; /* Lecture 50 */
    public $guarded = [];

    public function rooms()
    {
//        return $this->hasManyThrough('App\Room', 'App\TouristObject','city_id','object_id');
        return $this->morphToMany('App\Room', 'rsortable');
    }


    public function objects()
    {
        return $this->morphToMany('App\TouristObject', 'osortable');
    }



}
