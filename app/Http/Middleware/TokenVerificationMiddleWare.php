<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token=$request->cookie('token');

        $result=JWTToken::verifyToken($token);

        $userEmail=$result->userEmail??null;
        if(!$userEmail){
            return redirect('/');
        }
        $user=User::where('email',$userEmail)->first();
        if($result=="Unauthorized" || !$user){
            return redirect('/');
        }else{
            return $next($request);
        }

    }
}
