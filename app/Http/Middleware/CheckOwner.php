<?php


namespace App\Http\Middleware; /* Lecture 36 */

use Closure; /* Lecture 36 */
use Illuminate\Support\Facades\Auth; /* Lecture 36 */


/* Lecture 36 */
class CheckOwner
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
        if( Auth::user()->hasRole(['owner', 'admin'])) {

            return $next($request);

        }
        else {

            return redirect('/admin');
        }
    }
}

