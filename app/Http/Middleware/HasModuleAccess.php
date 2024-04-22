<?php

namespace App\Http\Middleware;

use Closure;

class HasModuleAccess
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
        // get the first segment of the route
        $module = request()->segment(1);
        if ($module){
            // dont check if it's ajax request
            if($request->ajax()) return $next($request);
            // get the user's associated module
            $module = auth()->user()->modules()->where('path', $module)->get();
            // user has associated on the module or no
            return $module->count() >= 1 ? $next($request) : abort(403);
        }
        return abort(403);
    }
}
