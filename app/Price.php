<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public $timestamps = false; /* Lecture 50 */
    public $guarded = []; /* Lecture 54 */
//    protected $dateFormat = 'm-d-Y';

    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
