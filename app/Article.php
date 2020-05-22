<?php
/*
|--------------------------------------------------------------------------
| app/Article.php **** Copyright netprogs.pl * avaiable only at Udemy.com * further distribution is prohibited  ****
|--------------------------------------------------------------------------
*/

namespace App; /* Lecture 16 */

use Illuminate\Database\Eloquent\Model; /* Lecture 16 */
use Illuminate\Support\Facades\Auth; /* Lecture 24 */

/* Lecture 16 */
class Article extends Model
{

    use Enjoythetrip\Presenters\ArticlePresenter; /* Lecture 23 */

    protected $guarded = []; /* Lecture 45 */
    public $timestamps = false; /* Lecture 45 */

    /* Lecture 16 */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /* Lecture 22 */
    public function users()
    {
        return $this->morphToMany('App\User', 'likeable');
    }

    /* Lecture 22 */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /* Lecture 22 */
    public function object()
    {
        return $this->belongsTo('App\TouristObject','object_id');
    }

    /* Lecture 24 */
    public function isLiked()
    {
        return $this->users()->where('user_id', Auth::user()->id)->exists();
    }
}

