<?php
/*
|--------------------------------------------------------------------------
| app/Http/Controllers/Controller.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session; /* Lecture 35 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /* Lecture 35 */
    protected function flashMsg($class, $message)
    {
        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-'.$class);
    }

}

