<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class OwnGameMiddleware
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

        if($request->game_slug->user_id == Auth::user()->id) {
            return $next($request);
        }

        return redirect('/profile');

    }
}
