<?php

namespace LaraStore\Forms\User;

use Auth;
use App\User;
use App\Models\Payment;
use LaraStore\Forms\Form;
use App\Models\Order;
use App\Http\Controllers\Front\BaseController;
use App\Http\Controllers\Api\ApiController as Api;

class PayFormAct extends Form{

	public $api;
    public $title   = '使用账户余额支付';
	/*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则
    |
    |-------------------------------------------------------------------------------
    */
    protected $rules = [
        
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 表单验证规则提示信息
    |
    |-------------------------------------------------------------------------------
    */
    protected $messages = [
       	
    ];


    /*
    |-------------------------------------------------------------------------------
    |
    | 构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Api $api){

       $this->api           = $api;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  品牌模型是否为空
    |
    |-------------------------------------------------------------------------------
    */
    public function isEmpty(){

        return (empty(Order::find($this->order_id)))? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  是否登录
    |
    |-------------------------------------------------------------------------------
    */
    public function auth(){

        return  (Auth::check('user'))? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  订单已支付
    |
    |-------------------------------------------------------------------------------
    */
    public function isPay(){

        return  ($this->order()->pay_status == 1)? true :false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  用户余额不够支付订单总金额
    |
    |-------------------------------------------------------------------------------
    */
    public function moneyEnough(){

        $amount         =  $this->order()->order_amount;
        $money          = Auth::user('user')->money();

        return ($amount > $money) ?  false :true;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  返回订单
    |
    |-------------------------------------------------------------------------------
    */
    public function  order(){

        return Order::find($this->order_id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  获取支付名称
    |
    |-------------------------------------------------------------------------------
    */
    public function payment(){

        return Payment::acPayModel();
    }

    

    /*
    |-------------------------------------------------------------------------------
    |
    |  成功后返回
    |
    |-------------------------------------------------------------------------------
    */
    public function successRespond(){

       $tag             = 'success';
       $info            = '使用余额支付订单成功，账号余额扣除金额：'.$this->order()->order_amount;
       
       //余额支付
       $this->accountPay();

       return $this->api->respond(['data'=>compact('tag','info')]);
    	
    }




    /*
    |-------------------------------------------------------------------------------
    |
    |  执行余额支付
    |
    |-------------------------------------------------------------------------------
    */
    public function accountPay(){
        //获取登录用户名称
        $user                   = Auth::user('user');
        $order                  = $this->order();
        $payment                = $this->payment();
        //创建支付记录
        $user->presenter()->accountPay($order);

        //修改订单状态 和订单支付名称
        $order->pay_id          = $payment->id;
        $order->pay_name        = $payment->pay_name;
        $order->pay_time        = time();
        $order->pay_status      = 1;
        $order->save();

        //修改子订单的状态
        $order->childPaySuccess();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  isValid
    |
    |-------------------------------------------------------------------------------
    */
    public function isValid(){

       if((!$this->isEmpty()) && $this->auth() && $this->moneyEnough() &&(!$this->isPay())){

           return true;
       }

       return false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |  验证未通过返回错误信息
    |
    |-------------------------------------------------------------------------------
    */
    public function errorRespond(){

        //订单为空
        if($this->isEmpty()){

            $info               = '订单不存在';
            return $this->api->respondCommonError($info);
        }
        
        //用户未登录
        if(!$this->auth()){
            $info               = '用户未登录';
            return $this->api->respondCommonError($info);
        }

        //用户余额不足
        if(!$this->moneyEnough()){

            $info               = '用户余额不足以支付订单金额';
            return $this->api->respondCommonError($info);
        }

        //订单已经支付
        if($this->isPay()){

            $info               = '订单已支付，无需再支付';
            return $this->api->respondCommonError($info);
        }
    }


    


    /*
    |-------------------------------------------------------------------------------
    |
    | 处理数据库相关操作
    |
    |-------------------------------------------------------------------------------
    */
    public function persist()
    {
         return true;
    }
}