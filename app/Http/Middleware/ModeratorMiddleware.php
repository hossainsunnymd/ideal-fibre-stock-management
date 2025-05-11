<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole=$request->session()->get('role');
        if($userRole=='moderator' || $userRole=='superadmin'){
             return $next($request);
        }else{
              return redirect('/');
        }

    }
}
