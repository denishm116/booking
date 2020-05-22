<?php

namespace App\Enjoythetrip\Presenters; /* Lecture 16 */

/* Lecture 16 */
trait UserPresenter {

    /* Lecture 16 */
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->surname;
    }

    public function getFullPayNameAttribute()
    {
        return $this->surname.' '.$this->name.' '.$this->patronymic;
    }

    public function getUserEmailAttribute()
    {
        return $this->email;
    }

    public function getUserPhoneAttribute()
    {
        return $this->phone;
    }

}

