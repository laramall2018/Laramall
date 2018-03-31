<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Controllers\Front\BaseController;

class MobileAuth
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
        $models       = [
                                'profile',      //个人资料
                                'order',        //订单
                                'return',       //退货
                                'address',      //地址
                                'tag',          //标签
                                'collect',      //收藏
                                'message',      //消息
                                'money',        //资金
                                'pay',          //支付
                                'sms',          //短消息

        ];

        $ctl          = new BaseController();

        //如果不是移动端直接退出
        if(!$ctl->is_mobile()){

            echo '请使用移动设备访问';
            exit;
        }


        //如果是前台用户 则直接返回
        if(Auth::user('user')){

            if(in_array($request->model,$models)){

                return $next($request);
            }
            else{

                return view('errors.404');
            }
        }

        return redirect('auth/login');
    }
}
