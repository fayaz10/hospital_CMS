<?php

namespace App\Http\Middleware;

use Closure;

class EnsureBackupLoad
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
        // $payment = \App\iSys\Services\UrlHelper::checkPayment();
        // dd($payment);
        // if (is_numeric($payment) && $payment > 0)
            // sleep($payment * 2);

        return $next($request);
    }
}
