<?php

namespace App\Http\Middleware;

use Closure;
use Phpstore\Log\Mylog;
use Route;


class LogMiddleware
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

        $route_name      		= Route::currentRouteName();
        $mylog              = new Mylog();
        //存储日志到日志数据表
        $mylog->put('route_name',$route_name);
        $mylog->log();
        return $next($request);
    }
}
