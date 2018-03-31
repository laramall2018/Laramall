<?php

namespace Phpstore\Repository;
use Auth;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\UserAddress;
use App\Models\Card;
use App\Models\OrderGoods;
use App\Models\Order;
use App\Models\OrderExpress;


trait OrderRepository{



	/*
    |-------------------------------------------------------------------------------
    |
    |   生成订单串号
    |
    |-------------------------------------------------------------------------------
    */
    public static function order_sn(){

    	/* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }


	/*
    |-------------------------------------------------------------------------------
    |
    |   生成一个新的订单信息
    |
    |-------------------------------------------------------------------------------
    */
    public static function createOrder(Array $arr){

    	if(!Auth::check('user')){

    		return false;
    	}
    	$user 			   = Auth::user('user');
    	$address 		   = $user->default_address();
    	$self 			   = new static;
    	//提取参数
    	$pay_id 		   = $arr['pay_id'];
    	$shipping_id 	   = $arr['shipping_id'];
    	$card_sn 		   = $arr['card_sn'];
    	//获取配送,礼品卡，支付模型
    	$pay 			   = Payment::find($pay_id);
    	$shipping 		   = Shipping::find($shipping_id);
    	$card_id 		   = ($card = Card::searchBy($card_sn))? $card->id : 0;
    	//商品总金额
    	$goods_amount 	   = $user->amount();
    	//订单总金额
    	$order_amount 	   = $self->orderAmount($arr);

    	$data              =       [

                                        'order_sn'       	=> $self->order_sn(),
                                        'user_id'        	=> Auth::user('user')->id,
                                        'order_status'   	=> 0,
                                        'shipping_status' 	=> 0,
                                        'pay_status'     	=> 0,
                                        'consignee'      	=>$address->consignee,
                                        'country'        	=>$address->country,
                                        'province'          =>$address->province,
                                        'city'           	=>$address->city,
                                        'district'       	=>$address->district,
                                        'address'        	=>$address->address,
                                        'phone'          	=>$address->phone,
                                        'email'          	=>$address->email,
                                        'shipping_id'    	=>$shipping_id,
                                        'shipping_name'     =>$shipping->shipping_name,
                                        'pay_id'         	=>$pay_id,
                                        'pay_name'       	=>$pay->pay_name,
                                        'goods_amount'   	=>$user->amount(),
                                        'shipping_fee'   	=>$shipping->fee,
                                        'order_amount'      =>$order_amount,
                                        'add_time'          =>time(),
                                        'card_id' 			=> ($user->presenter()->canCardPay($card_sn))? $card_id : 0,
                                        'ip'                =>request()->getClientIp(),

                                    ];
        $order 				= $self->create($data);
        //设置礼品卡的状态
        if($user->presenter()->canCardPay($card_sn)){

            Card::setTag($card_id,2);
        }
        return $order->id;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   计算订单的总金额
    |
    |-------------------------------------------------------------------------------
    */
    public static function orderAmount($arr){

    	 $shipping_id 					= $arr['shipping_id'];
    	 $card_sn 						= $arr['card_sn'];
    	 $user 							= Auth::user('user');
    	 //获取配送和礼品卡模型
    	 $gift_discount 				= ($card = Card::searchby($card_sn))? $card->price : 0;
    	 $shipping_fee 					= ($shipping = Shipping::find($shipping_id))? $shipping->fee : 0;
    	 $goods_amount 					= $user->amount();

         if($user->presenter()->canCardPay($card_sn)){

            return ($goods_amount + $shipping_fee - $gift_discount);
         }

         return ($goods_amount + $shipping_fee);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   购物车中商品移动到订单商品中
    |
    |-------------------------------------------------------------------------------
    */
    public function cartToOrderGoods(){

        if(!Auth::check('user')){
            return false;
        }
        $user      = Auth::user('user');
        foreach($user->cart()->where('is_checked',1)->get() as $cart){

            $data   = [
                            'order_id'          =>$this->id,
                            'goods_id'          =>$cart->goods_id,
                            'goods_name'        =>$cart->goods_name,
                            'goods_sn'          =>$cart->goods_sn,
                            'goods_number'      =>$cart->goods_number,
                            'shop_price'        =>$cart->shop_price,
                            'goods_attr'        =>$cart->goods_attr,
                            'market_price'      =>$cart->market_price,
                ];
            //创建订单商品模型
            OrderGoods::create($data);
        }
        $user->cart()->where('is_checked',1)->delete();
        return $this->order_goods;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取支付按钮
    |
    |-------------------------------------------------------------------------------
    */
    public function pay_btn(){

        return  $this->payment->get_pay_btn($this);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取下单日期
    |
    |-------------------------------------------------------------------------------
    */
    public function getCreateTimeAttribute(){
        return $this->time();
    }

    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单状态
    |
    |-------------------------------------------------------------------------------
    */
    public function getStatusAttribute(){
        return $this->status();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单详情链接
    |
    |-------------------------------------------------------------------------------
    */
    public function getUrlAttribute(){
        return url('auth/order/preview/'.$this->id);
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单详情链接
    |
    |-------------------------------------------------------------------------------
    */
    public static function mergeOrder($ids){

        if(count($ids) == 0){

            return false;
        }

        $firstOrder                     = (new static)->find($ids[0]);

        $order                          = new Order();
        $order->order_sn                = (new static)->order_sn();
        $order->user_id                 = Auth::user()->id;
        $order->pay_status              = 0;
        $order->order_status            = 0;
        $order->shipping_status         = 0;
        $order->return_status           = 0;
        $order->cancel_status           = 0;
        $order->goods_amount            = (new static)->amounts($ids);
        $order->shipping_fee            = $firstOrder->shipping_fee;
        $order->add_time                = time();
        $order->ip                      = request()->getClientIP();
        $order->order_from              = '批量下单总订单';
        $order->pay_id                  = $firstOrder->pay_id;
        $order->pay_name                = $firstOrder->pay_name;
        $order->shipping_id             = $firstOrder->shipping_id;
        $order->shipping_name           = $firstOrder->shipping_name;
        $order->order_amount            = (new static)->totals($ids);
        $order->consignee               = $firstOrder->consignee;
        $order->country                 = $firstOrder->country;
        $order->province                = $firstOrder->province;
        $order->city                    = $firstOrder->city;
        $order->district                = $firstOrder->district;
        $order->address                 = $firstOrder->address;
        $order->phone                   = $firstOrder->phone;
        $order->order_type              = 1;
        //创建订单
        $order->save();

        //设置子订单
        $order->children($ids);

        //把子订单中的订单产品 写入订单产品表中
        $order->children_goods($ids);

        return $order;
    }



    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单的发货单号
    |
    |-------------------------------------------------------------------------------
    */
    public function express(){

        return OrderExpress::where('order_sn',$this->order_sn)->first();
    }


    /*
    |-------------------------------------------------------------------------------
    |
    |   获取订单的子订单列表
    |
    |-------------------------------------------------------------------------------
    */
    public function childrens(){

        return (new static)->where('parent_id',$this->id)->where('order_type',0)->get();

    }
}