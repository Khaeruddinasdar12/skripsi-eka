<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CekAdmin
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
        if (Auth::guard('admin')->user()->role != 'superadmin') {

            return redirect()->back()->with('error', 'Hanya superadmin');
        }
            
        return $next($request);
    }
}
