<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class TouristObject extends Model
{

    protected $table = 'objects';
    public $timestamps = false;


    use Enjoythetrip\Presenters\ObjectPresenter;


    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }


    public function city()
    {
        return $this->belongsTo('App\City');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function photos()
    {
        return $this->morphMany('App\Photo', 'photoable')->orderby('main_photo', 'desc');
    }

    public function users()
    {
        return $this->morphToMany('App\User', 'likeable');
    }


    public function address()
    {
        return $this->hasOne('App\Address', 'object_id');
    }


    public function rooms()
    {
        return $this->hasMany('App\Room', 'object_id');
    }


    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }


    public function articles()
    {
        return $this->hasMany('App\Article', 'object_id');
    }

    public function isLiked()
    {
        if (Auth::user())
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

    public function ratings()
    {
        return $this->morphMany('App\Rating', 'ratingable');
    }

    public function hasUserMark($userId): bool
    {
        foreach ($this->ratings as $rating) {
            if ($rating->user_id == $userId)
                return true;

        }
        return false;
    }

    public function userMark($userId)
    {
        return $this->ratings()->where('user_id', $userId)->where('ratingable_id', $this->id)->first()->rating;
    }

    public function changeRating($userId, $rating)
    {
        if (!$this->hasUserMark($userId) && $rating <= 10) {
            $this->ratings()->firstOrCreate([
                'user_id' => $userId,
                'ratingable_type' => $this,
                'ratingable_id' => $this->id,
                'rating' => $rating,
            ]);
        }
        return $this->ratingCounter();

    }

    public function hasRating(): bool
    {
        if ($this->ratings->first() == null)
            return false;
        else
            return true;
    }

    public function ratingCounter()
    {
        $rating = [];
        if ($this->hasRating()) {
            foreach ($this->ratings as $item) {
                $rating[] = $item->rating;

            }
            return intdiv(array_sum($rating), count($rating));
        }
        return 0;

    }

    public function votedCounter()
    {
        return count($this->ratings()->where('ratingable_id', $this->id)->get());
    }

    /**
     * @return array
     */
    public function likesCounter()
    {
        $likeCounter = $this->users()->where('likeable_id', $this->id)->get();
        return count($likeCounter);
    }



//    public function scopeRating()
//    {
//        return $this->ratings()->getModel();
//    }
}

