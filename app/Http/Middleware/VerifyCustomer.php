<?php

namespace App\Http\Middleware;

use Closure;

class VerifyCustomer
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
        if ( Auth()->user()->role !== 'customer' ) {
          return redirect()->route('admin.user');
        }
        return $next($request);
    }
}
