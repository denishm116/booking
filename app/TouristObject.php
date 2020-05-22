<?php


namespace App; /* Lecture 12 */

use Illuminate\Database\Eloquent\Model; /* Lecture 12 */
use Illuminate\Support\Facades\Auth; /* Lecture 24 */

/* Lecture 12 */
class TouristObject extends Model
{

    protected $table = 'objects';
    public $timestamps = false; /* Lecture 44 */

    use Enjoythetrip\Presenters\ObjectPresenter; /* Lecture 23 */

    /* Lecture 15 */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }


    /* Lecture 14 */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /* Lecture 35 */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /* Lecture 14 */
    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable')->orderby('main_photo', 'desc');
    }

    /* Lecture 16 */
    public function users()
    {
        return $this->morphToMany('App\User', 'likeable');
    }

    /* Lecture 16 */
    public function address()
    {
        return $this->hasOne('App\Address','object_id');
    }

    /* Lecture 16 */
    public function rooms()
    {
        return $this->hasMany('App\Room','object_id');
    }

    /* Lecture 16 */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /* Lecture 16 */
    public function articles()
    {
        return $this->hasMany('App\Article','object_id');
    }

    /* Lecture 24 */
    public function isLiked()
    {
        return $this->users()->where('user_id', Auth::user()->id)->exists();
    }


    public function additionals()
    {
        return $this->morphedByMany('App\Additional', 'osortable');
    }

    public function infrastructures()
    {
        return $this->morphedByMany('App\Infrastructure', 'osortable');
    }

    public function types()
    {
        return $this->morphedByMany('App\Type', 'osortable');
    }

    public function distance()
    {
        return $this->belongsTo('App\Distance');
    }

}

