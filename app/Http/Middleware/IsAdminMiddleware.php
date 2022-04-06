<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->is_admin){
            // return response( 403);

            abort(403,'You are not Admin');
            
        }
        dd('this is admin');
         $next($request);
         return redirect('/dashboard');
    }
}
