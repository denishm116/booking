<?php

namespace App\Enjoythetrip\Presenters; /* Lecture 23 */

/* Lecture 23 */
trait ArticlePresenter {


    public function getLinkAttribute()
    {
        return route('article',['id'=>$this->id]);
    }

    public function getTypeAttribute()
    {
        return $this->title.' article';
    }

}

