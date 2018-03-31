<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class FrontAuth
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

        //如果是前台用户 则直接返回
        if(Auth::user('user')){

            return $next($request);

        }
        else{

            return redirect('auth/login');
        }
        
    }
}
