<?php

namespace App\Http\Middleware;

use Closure;
use Phpstore\Base\Base;
use Phpstore\Base\Sysinfo;
use Request;
use Route;

class PriviMiddleware
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
            $base 					    = new Base();
            $url 					      = Request::path();
            $route_name      		= Route::currentRouteName();

           if($base->check_admin_privi($route_name , $request))
           {
                return $next($request);
          }else{

              return $base->PriviSysinfo($route_name);
          }
    }
}
