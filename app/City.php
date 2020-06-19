<?php


namespace App;

use Illuminate\Database\Eloquent\Model;


class City extends Model
{


    protected $guarded = []; /* Lecture 38 */
    public $timestamps = false; /* Lecture 38 */


    /* Lecture 19 */
    public function rooms()
    {
        return $this->hasManyThrough('App\Room', 'App\TouristObject','city_id','object_id');
    }

    public function objects()
    {
        return $this->hasMany('App\TouristObject');
    }

    public function hasMatch($name): bool
    {
//        dd($name, $this->name);
        if ($name == $this->name) {
                return true;
        } else {
            return false;
        }

    }

}

