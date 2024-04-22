<?php

namespace App\Http\Middleware;

use Closure;

class SystemHasBeenBlocked
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
        abort(400, 'System has been blocked due payment delay.');
    }
}
