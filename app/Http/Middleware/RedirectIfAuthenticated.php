<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
//            dd(auth()->user()->modules);
            if (auth()->user()->modules()->count() <= 0) {
                return \Response::make(view('errors.403'), 403);
            }
            return redirect('/' . auth()->user()->modules->first()->path);
        }

        return $next($request);
    }
}
