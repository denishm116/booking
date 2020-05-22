<?php


namespace App\Http\Middleware; /* Lecture 37 */

use Closure; /* Lecture 37 */
use Illuminate\Support\Facades\Auth; /* Lecture 37 */

/* Lecture 37 */
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* 37 */
        if( Auth::user()->hasRole(['admin']) )
            return $next($request);
        else
            return redirect('/admin');
    }
}

