<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    protected $guarded = []; /* Lecture 38 */
    public $timestamps = false; /* Lecture 38 */

    public function object()
    {
        return $this->hasOne('App\TouristObject', 'distance_id');
    }
}
