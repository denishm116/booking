<?php

namespace App\Http\Middleware;

use Closure;


class CheckActive
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
        $user = session('user');

        if(isset($user) && $user->active == 0) {
            return $next($request);
        }
        return redirect()
            ->route('home');



    }
}
