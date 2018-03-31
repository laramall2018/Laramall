<?php

namespace LaraStore\Presenters;

use App\Models\Order;
use Auth;

class OrderPresenter{

	protected $order;
	/*
    |-------------------------------------------------------------------------------
    |
    |  构造函数
    |
    |-------------------------------------------------------------------------------
    */
    public function __construct(Order $order){
    	
    	$this->order  = $order;

    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   支付状态
    |
    |-------------------------------------------------------------------------------
    */
    public function pay_status(){
    	$arr 	= ['未支付','已支付'];
    	return (in_array($this->order->pay_status,[0,1]))? $arr[$this->order->pay_status]:$arr[0];
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   配送状态
    |
    |-------------------------------------------------------------------------------
    */
    public function shipping_status(){
    	$arr 	= ['未发货','已发货'];
    	return (in_array($this->order->shipping_status,[0,1]))? $arr[$this->order->shipping_status]: $arr[0];
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   魔术方式 获取
    |
    |-------------------------------------------------------------------------------
    */
    public function __get($property){

    	return (method_exists($this,$property))? call_user_func([$this,$property]) : false;
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取支付链接
    |
    |-------------------------------------------------------------------------------
    */
    public function paylink(){

    	return ($this->order->pay_status == 0)? url('order/payment/'.$this->order->id):false;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   设置订单状态
    |
    |-------------------------------------------------------------------------------
    */
    public function update($arr){
        foreach($arr as $key=>$value){
            $this->order->$key      = $value;
        }
        $this->order->save();
    }
}