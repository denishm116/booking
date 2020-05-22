<?php

namespace App\Enjoythetrip\Presenters;

trait RoomPresenter
{
    public function getPhotosAttribute()
    {
        return $this->photos()->orderBy('main_photo', 'desc')->get();

    }


}

