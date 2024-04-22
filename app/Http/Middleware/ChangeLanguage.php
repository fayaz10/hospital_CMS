<?php

namespace App\Http\Middleware;

use Closure;

class ChangeLanguage
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
        if ($request->session()->has('lang')) {
            \App::setlocale($request->session()->get('lang'));
        }
        // dd($request->session('lang'));
        return $next($request);
    }
}
