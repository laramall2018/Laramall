<?php

namespace Phpstore\Repository;
use Phpstore\Alipay\Common as Alipay;

trait PaymentRepository{


	/*
    |-------------------------------------------------------------------------------
    |
    |   获取支付方式图标
    |
    |-------------------------------------------------------------------------------
    */
    public function getPaymentIconAttribute(){

    	return url('front/common/'.$this->pay_code.'.png');
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取所有支付方式
    |
    |-------------------------------------------------------------------------------
    */
    public static function getListFromDatabase(){

    	$self 				= new static;
    	return $self->all();

    }


   /*
   |-------------------------------------------------------------------------------
   |
   |  获取商品品牌名称 From  Cache
   |
   |-------------------------------------------------------------------------------
   */
   public static function getList(){

      $self             = new static;
      $key              = 'get_payment_list';
      $funcName         = 'getListFromDatabase';
      return $self->getCacheData(compact('key','funcName'));
  }



   /*
   |-------------------------------------------------------------------------------
   |
   |  获取支付按钮
   |
   |-------------------------------------------------------------------------------
   */
   public function get_pay_btn($order){

      $funcName         = $this->pay_code.'PayBtn';
      if(in_array($this->pay_code,['alipay','weixin','account'])){
         return call_user_func([$this,$funcName],$order);
      }
      return false;
   }


   /*
   |-------------------------------------------------------------------------------
   |
   |  支付宝支付按钮
   |
   |-------------------------------------------------------------------------------
   */
   public function alipayPayBtn($order){

      if(empty($order)){

            return false;
        }

        $alipay                 = new Alipay();
        $order_goods            = $order->order_goods()->first();
        $goods                  = $order_goods->goods;

        $row                    = [

            'WIDout_trade_no'   =>$order->order_sn,
            'WIDsubject'        =>$goods->goods_name,
            'WIDtotal_fee'      =>$order->order_amount,
            'WIDbody'           =>$goods->goods_name,
            'WIDshow_url'       =>$goods->url(),
            'WIDit_b_pay'       =>'',
            'WIDextern_token'   =>'',

        ];

        return $alipay->get_pay_btn($row);
   }


   /*
   |-------------------------------------------------------------------------------
   |
   |  微信支付按钮
   |
   |-------------------------------------------------------------------------------
   */
   public function weixinPayBtn($order){
       if(empty($order)){
          return false;
       }

       return '<span class="btn btn-lg btn-default">暂未开通</span>';
   }


   /*
   |-------------------------------------------------------------------------------
   |
   |  用户余额支付
   |
   |-------------------------------------------------------------------------------
   */
   public function accountPayBtn($order){
      if(empty($order)){

         return false;

      }

      return '<a class="btn btn-lg btn-success" href="'
             .url('api/account/pay/'.$order->id).'">余额支付</a>';
   }


   /*
   |-------------------------------------------------------------------------------
   |
   |  获取余额支付的支付模型
   |
   |-------------------------------------------------------------------------------
   */
   public static function acPayModel(){

       return  (new static)->where('pay_code','account')->first();
   }
}