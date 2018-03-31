<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LaraStore\Sms\Sms;
use App\Models\Goods;
use Auth;
use App\Models\CollectGoods;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('sms', function ($attribute, $value, $parameters)
        {
             $sms       = new Sms();
             if($sms->put('phone',request()->phone)->get() == $value){
                return true;
             }
             return false;
        });

        $this->app['validator']->extend('goods_exist', function ($attribute, $value, $parameters)
        {
             if($value <= 0){
                return false;
             }
             $goods     = Goods::find($value);
             if(empty($goods)){
                return false;
             }
             return true;
        });

        $this->app['validator']->extend('collect_exist', function ($attribute, $value, $parameters)
        {   
            //检测商品完整性
             if($value <= 0){
                return false;
             }
             //未登录 直接返回
             if(!Auth::check('user')){
                return false;
             }
             $user        = Auth::user('user');
        
    return (CollectGoods::where('user_id',$user->id)->where('goods_id',$value)->first())? false:true;

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
