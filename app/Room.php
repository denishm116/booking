<?php
/*
|--------------------------------------------------------------------------
| app/Room.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

namespace App;
/* Lecture 16 */

use Illuminate\Database\Eloquent\Model; /* Lecture 16 */

/* Lecture 16 */

class Room extends Model
{
    use Enjoythetrip\Presenters\RoomPresenter;

    public $timestamps = false; /* Lecture 48 */
    protected $appends = ['has_main_photo'];

    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable');
    }

    /* Lecture 17 */
    public function object()
    {
        return $this->belongsTo('App\TouristObject', 'object_id');
    }

    /* Lecture 19 */
    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function rservices()
    {
        return $this->morphedByMany('App\Rservice', 'rsortable');
    }

    public function additionals()
    {
        return $this->morphedByMany('App\Additional', 'rsortable');
    }

    public function price()
    {
        return $this->hasOne('App\Price');
    }

    public function getHasMainPhotoAttribute()
    {
                foreach ($this->photos()->get() as $photo) {
            if ($photo->main_photo) {
                return true;
            }
        }

        return false;
    }


}

