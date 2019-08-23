<?php

namespace tniv\Http\Middleware;

use Closure;

class AdminMiddleware
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

        if ($request->user() && $request->user()->rol != 'Admin' && $request->user()->rol != 'Master')
        {
             return redirect('/unauthorized')->with('warning', 'Se necesitan permisos diferentes para ver esta página!');
        }

        return $next($request);
    }
}
