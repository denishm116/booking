<?php

namespace App\Enjoythetrip\Presenters;
/* Lecture 16 */

//namespace App\Enjoythetrip\Presenters; /* Lecture 16 */
use App\Comment;

/* Lecture 16 */

trait CommentPresenter
{

    public function getRatingStarAttribute()

    {
        $value = $this->rating;
        $str = '';

        for ($i = 1; $i <= 10; $i++) {
            $negr = 'fas';

            if ($value == 1 && $i > 1)
                $negr = 'far';

            elseif ($value == 2 && $i > 2)
                $negr = 'far';

            elseif ($value == 3 && $i > 3)
                $negr = 'far';

            elseif ($value == 4 && $i > 4)
                $negr = 'far';

            elseif ($value == 5 && $i > 5)
                $negr = 'far';

            elseif ($value == 6 && $i > 6)
                $negr = 'far';

            elseif ($value == 7 && $i > 7)
                $negr = 'far';

            elseif ($value == 8 && $i > 8)
                $negr = 'far';

            elseif ($value == 9 && $i > 9)
                $negr = 'far';

            $str .= '<i class="' . $negr . ' fa-star" aria-hidden="true"></i>';
        }

        return $str;

    }

    public function getAverageRatingAttribute()
    {
//        $arr = [];
//        foreach ($this->rating as $rating) {
//            $arr [] = $rating;
//        }
//        $value = array_sum($arr) % count($arr);
        $value = 5;

        $str = '';

        for ($i = 1; $i <= 10; $i++) {
            $negr = 'fas';

            if ($value == 1 && $i > 1)
                $negr = 'far';

            elseif ($value == 2 && $i > 2)
                $negr = 'far';

            elseif ($value == 3 && $i > 3)
                $negr = 'far';

            elseif ($value == 4 && $i > 4)
                $negr = 'far';

            elseif ($value == 5 && $i > 5)
                $negr = 'far';

            elseif ($value == 6 && $i > 6)
                $negr = 'far';

            elseif ($value == 7 && $i > 7)
                $negr = 'far';

            elseif ($value == 8 && $i > 8)
                $negr = 'far';

            elseif ($value == 9 && $i > 9)
                $negr = 'far';

            $str .= '<i class="' . $negr . ' fa-star" aria-hidden="true"></i>';
        }
        return $str;
    }
}


