<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminCheck
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


        if($request->path() == 'app/user-login'){
            return $next($request);
        }
        if(!Auth::check()){
            return response([
                'msg'=>'you are not allowed to access this route',
                'url'=>$request->path()
            ],403);
        }
        $user  = Auth::user();
        if( $user->userType =='User'){
            return response([
                'msg'=>'you are not allowed to access this route',
                'url'=>$request->path()
            ],403);
        }
        return $next($request);

    }
}
