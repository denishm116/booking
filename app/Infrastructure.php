<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infrastructure extends Model
{
    public $timestamps = false; /* Lecture 50 */
    public $guarded = [];

    public function objects()
    {
        return $this->morphToMany('App\TouristObject', 'osortable');
    }

}
